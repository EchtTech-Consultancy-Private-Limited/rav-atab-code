<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummaryReport extends Model
{
    use HasFactory;
    protected $table = "summary_report";

    protected $fillable = [
        'application_id',
        'course_id',
        'application_uid',
        'location_training_provider',
        'course_assessed',
        'way_of_desktop',
        'mandays',
        'assessor',
        'team',
        'team_leader',
        'assess_org',
        'brief_opening_meeting',
        'summary1',
        'summary2',
        'date',
        'date_of_application',
        'signature',
        'summary_type',
    ];

    public function chapters()
    {
        return $this->hasMany(SummaryReportChapter::class);
    }

    public function application(){
        return $this->belongsTo(Application::class,"application_id","id");
    }

    public function course(){
        return $this->belongsTo(ApplicationCourse::class,"course_id","id");
    }
}
