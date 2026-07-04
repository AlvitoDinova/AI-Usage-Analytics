<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalculationLog extends Model
{
    protected $table = 'calculation_logs';
    public $timestamps = false;

    protected $fillable = [
        'assessment_id',
        'tahap',
        'data_json',
    ];

    protected $casts = [
        'data_json' => 'array',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class, 'assessment_id');
    }
}
