<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class TblApplication extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'tbl_application';
    protected $fillable = ['refid','prev_refid','uhid','level_id','tp_id','person_name','email','contact_number','designation','tp_ip','user_type','application_date','valid_from'];

    public static function boot()
    {
        parent::boot();

        // Generate code before saving the model
        static::creating(function ($model) {
            $model->generateCode();
            $model->generateReferenceCode();
        });
    }

    public function generateCode()
    {
        $prefix = 'ATAB/TP-';
        $suffix = date('Y');

        $maxCode = static::where('uhid', 'like', "$prefix%$suffix")->max('uhid');

        if (!$maxCode) {
            $newCode = "$prefix" . str_pad('001', 3, '0', STR_PAD_LEFT) . "/$suffix";
        } else {
            $codeNumber = (int)substr($maxCode, -7, 3) + 1;
            $newCode = "$prefix" . str_pad($codeNumber, 3, '0', STR_PAD_LEFT) . "/$suffix";
        }

        $this->uhid = $newCode;
    }

    public function generateReferenceCode()
    {
        $prefix = 'ATAB/REF-';
        $suffix = date('Y');
        $codeNumber = 1;
        $lastCode = static::where('refid', 'like', "$prefix%$suffix")->latest()->value('uhid');
        if ($lastCode) {
            $lastCodeNumber = (int)substr($lastCode, -7, 3);
            $codeNumber = $lastCodeNumber + 1;
        }
        $newCode = "$prefix" . str_pad($codeNumber, 3, '0', STR_PAD_LEFT) . "/$suffix";
        $this->refid = $newCode;
    }
    public function getCodeAttribute()
    {
        return strtoupper($this->attributes['uhid']);
    }
}
