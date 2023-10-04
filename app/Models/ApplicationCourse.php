<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationCourse extends Model
{
    use HasFactory;

    protected $casts = [
        'mode_of_course' => 'array',
            'status'
    ];

    public function documents(){
        return $this->hasMany(ApplicationDocument::class,'course_number','id');
    }


}
