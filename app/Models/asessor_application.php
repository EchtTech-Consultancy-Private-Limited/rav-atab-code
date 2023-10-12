<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asessor_application extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function application(){
        return $this->belongsTo(Application::class,'application_id','id');
    }
}
