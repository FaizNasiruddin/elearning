<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentSubject extends Model
{
     protected $table = 'student_subject';

    protected $fillable = [
        'id',
        'student_id',
        'subject_id',
    ];

    public $timestamps = false; // Optional, if you don't use created_at/updated_at
    // Optional: If you don’t have timestamps (created_at, updated_at)
    // public $timestamps = false;

    // public function student()
    // {
    //     return $this->belongsTo(Students::class);
    // }

    // public function subject()
    // {
    //     return $this->belongsTo(Subjects::class);
    // }
}
