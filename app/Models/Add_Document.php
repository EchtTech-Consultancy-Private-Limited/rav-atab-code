<?php

namespace App\Models;
use App\Models\DocComment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Add_Document extends Model
{
    use HasFactory;
    protected $table = 'add_documents';

    public function question(){
        return $this->belongsTo(Question::class,'');
    }

    public function comments(){
        return $this->hasMany(DocComment::class,'doc_id','id');
    }

    public function comment(){
        return $this->hasOne(DocComment::class,'doc_id','id');
    }

}
