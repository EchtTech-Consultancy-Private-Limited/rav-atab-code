<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_details_file',
    ];

    public function application(){
        return $this->belongsTo(Application::class,'application_id','id');
    }
}
