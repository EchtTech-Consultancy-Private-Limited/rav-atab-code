<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'level_id',
        'gps_pic',
        'final_remark',
        'application_uid',
        'Person_Name',
        'Contact_Number',
        'Email_ID',
        'designation',
        'city',
        'state',
        'country',
        'ip',
        'status',
        'desktop_status',
        'onsite_status',
        'is_payment_acknowledge',
        'acknowledged_by'
    ];


    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastRecord = static::orderBy('id', 'desc')->first();
            $lastReference = $lastRecord ? $lastRecord->application_uid : 'RAVAP-4000';

            // Extract the number part and increment it
            $lastNumber = (int) substr($lastReference, 6);
            $nextNumber = $lastNumber + 1;

            // Create the new reference
            $nextReference = 'RAVAP-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // Assign the reference to the application_uid column
            $model->application_uid = $nextReference;
        });
    }

    public function assignees(){
        return $this->hasMany(AssessorApplication::class,"application_id","id");
    }

    public function courses(){
        return $this->hasMany(ApplicationCourse::class,"application_id","id");
    }

    public function payment(){
        return $this->hasOne(ApplicationPayment::class,"application_id","id");
    }

    public function payments(){
        return $this->hasMany(ApplicationPayment::class,"application_id","id");
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    

}
