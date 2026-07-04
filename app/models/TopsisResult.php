<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TopsisResult extends Model
{
    protected $table = 'topsis_results';
    public $timestamps = false;

    protected $fillable = [
        'assessment_id',
        'ai_id',
        'nilai_preferensi',
        'ranking',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class, 'assessment_id');
    }

    public function aiTool(): BelongsTo
    {
        return $this->belongsTo(AITool::class, 'ai_id');
    }
}
