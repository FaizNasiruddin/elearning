<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; // Import Authenticatable

class Students extends Authenticatable
{
    // Define the custom table name
    protected $table = 'students';

    protected $fillable = [
        'id',
        'username',
        'password',
        'fullname',
        'form',
    ];

    public $timestamps = true; // Optional, if you don't use created_at/updated_at
    // Optional: If you don’t have timestamps (created_at, updated_at)
    // public $timestamps = false;

    public function subjects()
    {
        return $this->belongsToMany(Subjects::class, 'student_subject', 'student_id', 'subject_id');
    }

    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class);
    }

}