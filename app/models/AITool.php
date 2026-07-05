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

    public function projectTypes()
    {
        return $this->belongsToMany(ProjectType::class, 'project_type_ai_tools', 'ai_tool_id', 'project_type_id')->withTimestamps();
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_ai_tools', 'ai_tool_id', 'project_id')->withTimestamps();
    }
}
