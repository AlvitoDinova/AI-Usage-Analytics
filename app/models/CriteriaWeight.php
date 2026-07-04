<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CriteriaWeight extends Model
{
    protected $table = 'criteria_weights';
    public $timestamps = false;

    protected $fillable = [
        'criteria_id',
        'bobot',
    ];

    public function criterion(): BelongsTo
    {
        return $this->belongsTo(Criterion::class, 'criteria_id');
    }
}
