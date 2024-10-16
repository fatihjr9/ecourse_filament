<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ["nama", "thumbnail", "deskripsi", "harga"];
    public function subCourses()
    {
        return $this->hasMany(SubCourse::class);
    }
    public function checkouts()
    {
        return $this->belongsToMany(Checkout::class, "course_checkout"); // Gunakan nama tabel pivot yang sesuai
    }
}
