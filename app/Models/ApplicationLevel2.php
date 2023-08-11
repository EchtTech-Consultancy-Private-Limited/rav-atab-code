<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationLevel2 extends Model
{
    use HasFactory;
    protected $table = 'application_level2';
    protected $fillable = [
        'level_id',
        'user_id',
        'person_name',
        'contact_no',
        'email',
        'country',
        'state',
        'city',
        'ip',
        'status',
        'designation'
    ];
}
