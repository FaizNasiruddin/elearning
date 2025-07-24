<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chatbot extends Model
{
        protected $table = 'chatbots';

    protected $fillable = [
        'name',
        'bot_id',
        'kb_id',
        'pat',
        'script',
        'created_at',
        'updated_at' // so you can insert them manually
    ];

    public $timestamps = true ;

}
