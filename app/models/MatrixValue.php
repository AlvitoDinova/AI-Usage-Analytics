<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatrixValue extends Model
{
    protected $table = 'matrix_values';
    public $timestamps = false;

    protected $fillable = [
        'project_id',
        'ai_id',
        'criteria_id',
        'nilai',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function aiTool(): BelongsTo
    {
        return $this->belongsTo(AITool::class, 'ai_id');
    }

    public function criterion(): BelongsTo
    {
        return $this->belongsTo(Criterion::class, 'criteria_id');
    }
}
