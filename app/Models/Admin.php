<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin'; // Your table is named 'admin'

    protected $fillable = ['username', 'password'];

    public $timestamps = false; // Disable if 'created_at' and 'updated_at' are not in the table
}