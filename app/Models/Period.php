<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Period extends Model
{
    protected $table = '2_periods';

    protected $fillable = [
        'identifier',
        'label_en',
        'description_en',
        'parent_id',
        'start_year',
        'end_year',
        'start_uncertain',
        'end_uncertain',
        'color',
        'wikidata_id',
        'wikidata_mapping',
    ];

    protected $casts = [
        'start_uncertain' => 'boolean',
        'end_uncertain' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Period::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Period::class, 'parent_id');
    }

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, '3_pivot_game_period', 'period_id', 'game_id')
                    ->withTimestamps();
    }

    public function alternativeNames(): HasMany
    {
        return $this->hasMany(AlternativeName::class, 'vocabulary_id')
                    ->where('vocabulary_type', 'period');
    }

    /**
     * Get the Wikidata URL
     */
    public function getWikidataUrlAttribute(): ?string
    {
        return $this->wikidata_id ? "https://www.wikidata.org/wiki/{$this->wikidata_id}" : null;
    }
}
