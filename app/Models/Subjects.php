<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
     protected $table = 'subjects';

    protected $fillable = [
        'id',
        'name',
        'color',
        'teacher_id',
        'form',
    ];

    public $timestamps = false; // Optional, if you don't use created_at/updated_at
    // Optional: If you don’t have timestamps (created_at, updated_at)
    // public $timestamps = false;

    // public function students()
    // {
    //     return $this->belongsToMany(Students::class, 'student_subjects', 'subject_id', 'student_id');
    // }

    
// In Subject.php model
   public function students()
    {
        return $this->belongsToMany(Students::class, 'student_subject', 'subject_id', 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teachers::class);
    }
}
