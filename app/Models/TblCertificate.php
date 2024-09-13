<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TblCertificate extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'tbl_certificate';
    protected $fillable = [
        'application_id', 'refid', 'certificate_no', 'certificate_file', 
        'status', 'valid_till', 'valid_from', 'level_id', 
        'created_at', 'updated_at', 'deleted_at'
    ];
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->generateCertificateNumber();
        });
    }
    public function generateCertificateNumber()
    {
        $prefix = 'ATAB/AAC/';
        $currentYear = date('y');
        $nextYear = date('y', strtotime('+1 year'));
        $financialYear = "$currentYear-$nextYear";

        $maxCertificateNo = static::where('certificate_no', 'like', "$prefix%/$financialYear")->max('certificate_no');
        if (!$maxCertificateNo) {
            $newNumber = str_pad('1', 5, '0', STR_PAD_LEFT);
        } else {
            $numberPart = preg_match('/(\d+)(?=\/\d{2}-\d{2}$)/', $maxCertificateNo, $matches) ? $matches[1] : '0';
            $newNumber = str_pad((int)$numberPart + 1, 5, '0', STR_PAD_LEFT);
        }
        $this->certificate_no = "$prefix{$newNumber}/$financialYear";
    }
}
