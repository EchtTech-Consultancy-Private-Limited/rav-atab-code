<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRemark extends Model
{
    use HasFactory;

    protected $table = "document_remarks";

    protected $fillable = [
        'id',
        'application_id',
        'document_id',
        'tp_id',
        'assessor_id',
        'remark',
        'created_by'
    ];

    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class,"created_by","id");
    }
}
