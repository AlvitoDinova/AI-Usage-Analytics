<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectType extends Model
{
    protected $table = 'project_types';
    public $timestamps = false;

    protected $fillable = [
        'nama_proyek',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'project_type_id');
    }
}
