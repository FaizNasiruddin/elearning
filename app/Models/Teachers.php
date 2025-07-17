<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; // Import Authenticatable

class Teachers extends Authenticatable
{
    // Define the custom table name
    protected $table = 'teachers';

    protected $fillable = [
        'id',
        'fullname',
        'username',
        'password',
    ];

    public $timestamps = true;

}