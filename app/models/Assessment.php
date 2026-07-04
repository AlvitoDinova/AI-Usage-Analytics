<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assessment extends Model
{
    protected $table = 'assessments';
    public $timestamps = false;

    protected $fillable = [
        'project_id',
        'tanggal_penilaian',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(AssessmentDetail::class, 'assessment_id');
    }

    public function topsisResults(): HasMany
    {
        return $this->hasMany(TopsisResult::class, 'assessment_id');
    }

    public function calculationLogs(): HasMany
    {
        return $this->hasMany(CalculationLog::class, 'assessment_id');
    }
}
