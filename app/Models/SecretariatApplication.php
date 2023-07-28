<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecretariatApplication extends Model
{
    use HasFactory;
    protected $table='secretariat';
    protected $fillable = [
        'secretariat_id',
        'application_id',
        'secretariat_type',
        'status',
        'due_date',
        'title',
    ];
}
