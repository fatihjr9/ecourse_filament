<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserProductController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Filament\Pages\listKursus;

Route::get("/course/register", [AuthController::class, "getRegister"])->name(
    "filament.course.auth.register"
);
Route::post("/course/register", [AuthController::class, "storeRegister"])->name(
    "filament.course.auth.register.store"
);
Route::get("/", [UserProductController::class, "index"])->name("index");
Route::get("/detail/{id}", [UserProductController::class, "detail"])->name(
    "detail"
);
Route::post("/detail/{id}", [CartController::class, "addToCart"])->name(
    "cart.add"
);
//

Route::get("/cart", function () {
    if (!Auth::check()) {
        return redirect()->route("filament.course.auth.login");
    }
    return app(CartController::class)->viewCart();
})->name("cart.index");

Route::delete("/cart/remove/{id}", function ($id) {
    if (!Auth::check()) {
        return redirect()->route("filament.course.auth.login");
    }
    return app(CartController::class)->removeFromCart($id);
})->name("cart.remove");
Route::post("/payment/callback", [
    CartController::class,
    "handlePaymentCallback",
])->withoutMiddleware([
    \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
]);
//
Route::get("/kursus-saya/{course}", listKursus::class)->name(
    "kursus-saya.detail"
);
