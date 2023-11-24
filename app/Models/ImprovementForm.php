<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImprovementForm extends Model
{
    use HasFactory;

    protected $table ="improvement_form";

    protected $fillable = [
        'application_id',
        'course_id',
        'training_provider_name',
        'course_name',
        'way_of_assessment',
        'mandays',
        'sr_no',
        'opportunity_for_improvement',
        'standard_reference',
        'signature',
        'name',
        'team_leader',
        'assessor_name',
        'rep_assessee_orgn',
        'date_of_submission',
    ];
}
