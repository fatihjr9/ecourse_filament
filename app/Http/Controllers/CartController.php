<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Midtrans\Notification;

class CartController extends Controller
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey = config("services.midtrans.serverKey");
        \Midtrans\Config::$isProduction = config(
            "services.midtrans.isProduction"
        );
        \Midtrans\Config::$isSanitized = config(
            "services.midtrans.isSanitized"
        );
        \Midtrans\Config::$is3ds = config("services.midtrans.is3ds");
    }
    public function addToCart($item_id)
    {
        $existingCartItem = Cart::where("user_id", Auth::id())
            ->where("item_id", $item_id)
            ->first();

        if ($existingCartItem) {
            return redirect()
                ->back()
                ->with("message", "Kursus sudah ada di keranjang!");
        }

        // Jika kursus belum ada di keranjang, tambahkan
        Cart::create([
            "user_id" => Auth::id(),
            "item_id" => $item_id,
        ]);

        return redirect()
            ->back()
            ->with("message", "Kursus berhasil ditambahkan ke keranjang!");
    }

    public function viewCart()
    {
        $userId = Auth::id();
        $cartItems = Cart::where("user_id", Auth::id())->get();
        $counted = $cartItems->count();
        $total = $cartItems->sum(function ($item) {
            return $item->item->harga;
        });

        if (!$userId) {
            return redirect()->route("filament.course.auth.login");
        }

        $cart = Cart::where("user_id", $userId)->get();

        if ($cart->isEmpty()) {
            return response()->json(["message" => "Cart is empty"], 400);
        }

        $courses = $cart->map(function ($item) {
            return $item->item;
        });

        $totalAmount = $courses->sum("harga");

        // Buat entry di tabel checkout
        $checkout = Checkout::create([
            "user_id" => $userId,
            "amount" => $totalAmount,
            "status" => "pending",
        ]);

        // Attach courses ke checkout
        $checkout->courses()->attach($courses->pluck("id"));

        // Set parameter untuk Midtrans
        $payload = [
            "transaction_details" => [
                "order_id" => $checkout->id,
                "gross_amount" => $totalAmount,
            ],
            "customer_details" => [
                "first_name" => Auth::user()->name,
                "email" => Auth::user()->email,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($payload);
        } catch (\Exception $e) {
            return response()->json(
                ["message" => "Failed to get snap token: " . $e->getMessage()],
                500
            );
        }

        return view(
            "pages.cart",
            compact("cartItems", "counted", "total", "snapToken")
        );
    }
    public function handlePaymentCallback(Request $request)
    {
        // Mengambil notifikasi dari Midtrans
        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $orderId = $notification->order_id;

        // Temukan data checkout berdasarkan order_id dari Midtrans
        $checkout = Checkout::find($orderId);

        if (!$checkout) {
            return response()->json(["message" => "Order not found"], 404);
        }

        // Cek status pembayaran dari Midtrans
        if (
            $transactionStatus == "capture" ||
            $transactionStatus == "settlement"
        ) {
            // Jika pembayaran berhasil, update status menjadi "paid"
            $checkout->update([
                "status" => "Paid",
            ]);

            // Hapus semua item dari keranjang pengguna
            Cart::where("user_id", $checkout->user_id)->delete();

            return response()->json(
                ["message" => "Payment successful and cart cleared"],
                200
            );
        } elseif (
            $transactionStatus == "deny" ||
            $transactionStatus == "expire" ||
            $transactionStatus == "cancel"
        ) {
            // Jika pembayaran gagal atau dibatalkan, update status menjadi "failed"
            $checkout->update([
                "status" => "failed",
            ]);

            return response()->json(
                ["message" => "Payment failed or cancelled"],
                400
            );
        } else {
            return response()->json(
                ["message" => "Unknown payment status"],
                400
            );
        }
    }
    public function removeFromCart($item_id)
    {
        Cart::where("user_id", Auth::id())
            ->where("item_id", $item_id)
            ->delete();

        return redirect()
            ->back()
            ->with("message", "Kursus berhasil dihapus dari keranjang!");
    }
}
