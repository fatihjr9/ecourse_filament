<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCourse extends Model
{
    protected $fillable = ["course_id", "judul", "link"];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    use HasFactory;
}
