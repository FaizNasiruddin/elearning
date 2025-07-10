<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $table = 'questions';

    protected $fillable = [
        'quiz_id',
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quizzes::class, 'quiz_id');
    }
}
