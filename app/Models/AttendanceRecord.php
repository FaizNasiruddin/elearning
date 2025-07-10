<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'attendance_records';

    // Define the fields that can be mass-assigned
    protected $fillable = [
        'student_id',
        'attendance_id',
        'ticked_at',
    ];

    public $timestamps = false; 

    // public function student()
    // {
    //     return $this->belongsTo(Students::class, 'student_id'); // assuming attendance record has 'student_id'
    // }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'attendance_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
