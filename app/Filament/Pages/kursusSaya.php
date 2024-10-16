<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Models\Checkout;

class kursusSaya extends Page
{
    protected static ?string $navigationIcon = "heroicon-o-document-text";
    protected static string $view = "filament.pages.kursus-saya";

    public $courses;

    public static function shouldRegisterNavigation(): bool
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole("super_admin")) {
                return false;
            }
            return $user->hasRole("user");
        }

        return false;
    }

    public function mount()
    {
        $user = Auth::user();
        if (!$user || $user->hasRole("super_admin")) {
            abort(403);
        }

        $purchasedCourses = Checkout::where("user_id", $user->id)
            ->where("status", "Paid")
            ->with("courses")
            ->get();

        $this->courses = $purchasedCourses->flatMap(function ($checkout) {
            return $checkout->courses;
        });

        if ($this->courses->isEmpty()) {
            $this->courses = collect();
        }
    }

    // Untuk menjamin properti 'courses' terkirim ke view
    public function getViewData(): array
    {
        return [
            "courses" => $this->courses,
        ];
    }
}
