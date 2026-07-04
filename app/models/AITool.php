<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AITool extends Model
{
    protected $table = 'ai_tools';

    protected $fillable = [
        'nama_ai',
        'developer',
        'kategori',
        'website',
        'deskripsi',
        'status',
    ];

    public function matrixValues(): HasMany
    {
        return $this->hasMany(MatrixValue::class, 'ai_id');
    }

    public function topsisResults(): HasMany
    {
        return $this->hasMany(TopsisResult::class, 'ai_id');
    }
}
