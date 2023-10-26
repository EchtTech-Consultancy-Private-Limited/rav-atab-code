<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessorApplication extends Model
{
    use HasFactory;

    protected $table = "asessor_applications";

    protected $fillable = [
        'assessor_id',
        'application_id',
        'assessment_type',
        'due_date',
        'notification_status',
        'read_by',
    ];

    public function user(){
        return $this->belongsTo(User::class,'assessor_id','id');
    }
}
