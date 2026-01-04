<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class VocabularyMapping extends Model
{
    protected $table = '2_vocabulary_mappings';

    protected $fillable = [
        'concept_type',
        'concept_id',
        'match_type',
        'external_uri',
        'external_source',
    ];

    public function concept(): MorphTo
    {
        return $this->morphTo();
    }
}
