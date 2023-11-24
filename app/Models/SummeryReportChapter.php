<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummeryReportChapter extends Model
{
    use HasFactory;
    protected $table = 'summary_report_chapters';

    protected $fillable = [
        'summary_report_application_id',
        'question_id',
        'nc_raised',
        'capa_training_provider',
        'document_submitted_against_nc',
        'remark',
    ];
}
