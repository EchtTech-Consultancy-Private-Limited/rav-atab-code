<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummeryReport extends Model
{
    use HasFactory;
    protected $table = 'summary_report';

    protected $fillable = [
        'application_uid',
        'date_of_application',
        'application_id',
        'course_id',
        'location_training_provider',
        'course_assessed',
        'way_of_desktop',
        'mandays',
        'signature',
        'assessor'
    ];

    public function SummeryReportChapter(){
        return $this->hasMany(SummeryReportChapter::class,'summary_report_application_id');
    }
}
