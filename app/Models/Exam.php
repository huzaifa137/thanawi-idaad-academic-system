<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'exam_type',
        'academic_year',
    ];

    /**
     * Relationships
     */

    // Exam belongs to a school
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // Exam has many student exam results
    public function studentExamResults()
    {
        return $this->hasMany(StudentExamResult::class);
    }
}
