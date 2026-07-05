<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = [
        'project_type_id',
        'nama_proyek',
        'client',
        'deskripsi',
        'status',
        'tanggal',
    ];

    public function projectType(): BelongsTo
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }

    public function assessment(): HasOne
    {
        return $this->hasOne(Assessment::class, 'project_id');
    }

    public function aiTools()
    {
        return $this->belongsToMany(AITool::class, 'project_ai_tools', 'project_id', 'ai_tool_id')->withTimestamps();
    }
}
