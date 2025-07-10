<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentQuizMark extends Model
{
    use HasFactory;

    protected $table = 'student_quiz_marks';

    protected $fillable = [
        'student_id',
        'quiz_id',
        'score',
        'total_questions',
    ];

    // Relationships (optional, if you have these models)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function quiz()
    {
        return $this->belongsTo(Quizzes::class, 'quiz_id');
    }
}