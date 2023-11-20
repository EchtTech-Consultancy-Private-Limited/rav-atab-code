<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationNotification extends Model
{
    use HasFactory;

    protected $table = 'application_notification';

    protected $fillable = [
        'application_id',
        'is_read',
        'notification_type'
    ];

    public function application(){
        return $this->belongsTo(Application::class,"application_id","id");
    }
}
