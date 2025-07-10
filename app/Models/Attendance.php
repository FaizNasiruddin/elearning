<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    // If you are using default table name (attendance), no need to specify it. 
    // If the table name was different, you would specify it like:
    // protected $table = 'your_custom_table_name';

    // The primary key for the model (attendance_id in this case)

    protected $table = 'attendances';

    // Fields that are mass assignable
    protected $fillable = [
        'id',
        'subject_id',
        'created_at',
        'start_time',
        'due_time',
        'password',
    ];

    // Disable timestamps if you are not using created_at / updated_at columns
    public $timestamps = false;

    public function subject()
    {
        return $this->belongsTo(Subjects::class, 'subject_id');
    }
}