<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Add_Document extends Model
{
    use HasFactory;
    protected $table = 'add_documents';

    public function question(){
        return $this->belongsTo(Question::class,'');
    }

    public function comment(){
        return $this->hasOne(Comment::class,'doc_id','id');
    }

}
