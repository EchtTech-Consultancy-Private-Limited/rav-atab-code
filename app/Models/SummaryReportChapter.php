<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummaryReportChapter extends Model
{
    use HasFactory;

    protected $table = "summary_report_chapters";

    protected $fillable = [
        'question_id',
        'nc_raised',
        'capa_training_provider',
        'document_submitted_against_nc',
        'remark',
    ];

    public function report()
    {
        return $this->belongsTo(SummaryReport::class, 'summary_report_application_id');
    }
}
