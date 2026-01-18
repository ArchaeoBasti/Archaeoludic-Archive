<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'tgn_mapping',
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
        return $this->belongsToMany(Game::class, '3_pivot_game_place', 'place_id', 'game_id')
                    ->withTimestamps();
    }

    public function alternativeNames(): HasMany
    {
        return $this->hasMany(AlternativeName::class, 'vocabulary_id')
                    ->where('vocabulary_type', 'place');
    }

    /**
     * Get the Getty TGN URL
     */
    public function getTgnUrlAttribute(): ?string
    {
        return $this->tgn_id ? "http://vocab.getty.edu/tgn/{$this->tgn_id}" : null;
    }
}
