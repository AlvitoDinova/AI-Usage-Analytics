<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Criterion extends Model
{
    protected $table = 'criteria';

    protected $fillable = [
        'kode',
        'nama_kriteria',
        'tipe',
        'deskripsi',
    ];

    public function defaultWeight(): HasOne
    {
        return $this->hasOne(CriteriaWeight::class, 'criteria_id');
    }

    public function matrixValues(): HasMany
    {
        return $this->hasMany(MatrixValue::class, 'criteria_id');
    }

    public function assessmentDetails(): HasMany
    {
        return $this->hasMany(AssessmentDetail::class, 'criteria_id');
    }
}
