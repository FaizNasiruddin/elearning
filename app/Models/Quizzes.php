<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quizzes extends Model
{
    // Define the custom table name
    protected $table = 'quizzes';

    // Allow mass assignment on these fields
    protected $fillable = [
        'title',
        'subject_id',
        'start_time',
        'end_time',
        'time_limit',
    ];

    public $timestamps = true; // If you're using created_at and updated_at

    // Relationship: a quiz belongs to one subject
    
    public function subject()
    {
        return $this->belongsTo(Subjects::class, 'subject_id');
    }

    public function questions()
    {
        return $this->hasMany(Questions::class, 'quiz_id');
    }
}
