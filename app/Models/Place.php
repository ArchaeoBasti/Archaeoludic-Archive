<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Place extends Model
{
    protected $table = '2_places';

    protected $fillable = [
        'identifier',
        'label_en',
        'description_en',
        'parent_id',
        'latitude',
        'longitude',
        'tgn_id',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Place::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Place::class, 'parent_id');
    }

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, '1_game_place', 'place_id', 'game_id')
                    ->withTimestamps();
    }

    public function mappings(): MorphMany
    {
        return $this->morphMany(VocabularyMapping::class, 'concept');
    }
}
