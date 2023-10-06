<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    public function chapter(){
        return $this->belongsTo(Chapter::class);
    }

    public function documents(){
        return $this->hasMany(Add_Document::class,'doc_id','code');
    }
}
