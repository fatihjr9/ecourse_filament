<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserActivity extends Controller
{
    public function showCourse()
    {
        $purchasedCourses = Checkout::where("user_id", auth()->id())
            ->where("status", "Paid")
            ->with("course")
            ->get();

        $courses = $purchasedCourses->map(function ($checkout) {
            return $checkout->item;
        });

        return view("filament.pages.kursus-saya", compact("courses"));
    }
}
