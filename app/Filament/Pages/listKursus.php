<?php

namespace App\Filament\Pages;

use App\Models\Course;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class listKursus extends Page
{
    protected static ?string $navigationIcon = "heroicon-o-document-text";

    public $course;
    public $subCourses;
    public function getHeading(): string
    {
        return $this->course->nama;
    }

    protected static string $view = "filament.pages.list-kursus";
    public static function shouldRegisterNavigation(): bool
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole("super_admin")) {
                return false;
            }
            return false;
        }
    }

    public function mount($course)
    {
        if (!Auth::check() || !Auth::user()->hasRole("user")) {
            abort(403);
        }
        $this->course = Course::findOrFail($course);
        $this->subCourses = $this->course->subCourses; // Ambil subCourses dari course yang dipilih
    }
}
