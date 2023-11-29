<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'doc_id',
        'comments',
        'status',
        'doc_code',
        'user_id',
        'course_id',
        'by_onsite_assessor',
    ];
    
    
    
}
