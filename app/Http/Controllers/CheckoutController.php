<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use App\Models\Cart;
use App\Models\Checkout;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env("MIDTRANS_SERVER_KEY");
        Config::$isProduction = env("MIDTRANS_IS_PRODUCTION");
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function checkout(Request $request)
    {
        return view("pages.cart", compact("snapToken", "totalAmount"));
    }
}
// Cart::where("user_id", $userId)->delete();
