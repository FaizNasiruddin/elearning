<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectFiles extends Model
{
    protected $table = 'subjects_files';

    protected $fillable = [
        'subject_id',
        'filename',
        'filetype',
        'filesize',
        'filedata',
        'uploaded_at'
    ];

    public $timestamps = false; // 👈 THIS FIXES THE ERROR

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

}