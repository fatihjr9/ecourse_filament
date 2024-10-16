<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class UserProductController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view("pages.index", compact("courses"));
    }
    public function detail($id)
    {
        $user = Auth::user();
        if (!$user) {
            // Kamu bisa mengarahkan ke halaman login atau menampilkan pesan error
            return redirect()
                ->route("filament.course.auth.login")
                ->with("error", "Anda harus login terlebih dahulu.");
        }
        // Ambil data kursus dan sub-kursusnya
        $courses = Course::where("id", $id)
            ->with([
                "subCourses" => function ($query) {
                    $query->take(4);
                },
            ])
            ->first();

        // Cek jika $courses tidak ditemukan
        if (!$courses) {
            // Kamu bisa mengarahkan ke halaman 404 atau menampilkan pesan error
            abort(404, "Kursus tidak ditemukan.");
        }

        // Cek apakah kursus ini sudah dibayar oleh user
        $isPaid = Checkout::where("user_id", $user->id)
            ->whereHas("courses", function ($query) use ($id) {
                $query->where("courses.id", $id); // Tambahkan "courses.id" agar tidak ambigu
            })
            ->where("status", "Paid")
            ->exists();

        // Hitung total sub-kursus
        $totalSubCourses = $courses->subCourses()->count();
        $total = max($totalSubCourses - 4, 0);

        // Ambil kursus lainnya yang tidak sama dengan kursus ini
        $relatedCourses = Course::where("id", "!=", $courses->id)
            ->take(4)
            ->get();

        // Ambil link preview sub-kursus pertama
        $preview = $courses->subCourses->firstWhere("id", 1)?->link;

        return view(
            "pages.detail",
            compact(
                "courses",
                "total",
                "preview",
                "relatedCourses",
                "totalSubCourses",
                "isPaid"
            )
        );
    }
}
