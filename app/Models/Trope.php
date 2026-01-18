<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trope extends Model
{
    protected $table = '2_tropes';

    protected $fillable = [
        'identifier',
        'label_en',
        'description_en',
        'tvtropes_url',
        'tvtropes_mapping',
        'wikidata_id',
        'wikidata_mapping',
    ];

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, '3_pivot_game_trope', 'trope_id', 'game_id')
                    ->withTimestamps();
    }

    public function alternativeNames(): HasMany
    {
        return $this->hasMany(AlternativeName::class, 'vocabulary_id')
                    ->where('vocabulary_type', 'trope');
    }

    /**
     * Get the TV Tropes URL
     */
    public function getTvTropesLinkAttribute(): ?string
    {
        return $this->tvtropes_url;
    }

    /**
     * Get the Wikidata URL
     */
    public function getWikidataUrlAttribute(): ?string
    {
        return $this->wikidata_id ? "https://www.wikidata.org/wiki/{$this->wikidata_id}" : null;
    }
}
