<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AlternativeName extends Model
{
    protected $table = '3_alternative_names';

    protected $fillable = [
        'vocabulary_type',
        'vocabulary_id',
        'name',
        'language',
    ];

    public function vocabulary(): MorphTo
    {
        return $this->morphTo('vocabulary', 'vocabulary_type', 'vocabulary_id');
    }
}
