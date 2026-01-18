<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    protected $table = '2_persons';

    protected $fillable = [
        'identifier',
        'label_en',
        'description_en',
        'gnd_id',
        'gnd_mapping',
        'wikidata_id',
        'wikidata_mapping',
        'birth_year',
        'death_year',
    ];

    protected $casts = [
        'birth_year' => 'integer',
        'death_year' => 'integer',
    ];

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, '3_pivot_game_person', 'person_id', 'game_id')
                    ->withTimestamps();
    }

    public function alternativeNames(): HasMany
    {
        return $this->hasMany(AlternativeName::class, 'vocabulary_id')
                    ->where('vocabulary_type', 'person');
    }

    /**
     * Get the GND URL
     */
    public function getGndUrlAttribute(): ?string
    {
        return $this->gnd_id ? "https://d-nb.info/gnd/{$this->gnd_id}" : null;
    }

    /**
     * Get the Wikidata URL
     */
    public function getWikidataUrlAttribute(): ?string
    {
        return $this->wikidata_id ? "https://www.wikidata.org/wiki/{$this->wikidata_id}" : null;
    }

    /**
     * Get formatted lifespan string
     */
    public function getLifespanAttribute(): ?string
    {
        if (!$this->birth_year && !$this->death_year) {
            return null;
        }

        $birth = $this->birth_year ? $this->formatYear($this->birth_year) : '?';
        $death = $this->death_year ? $this->formatYear($this->death_year) : '?';

        return "{$birth} – {$death}";
    }

    /**
     * Format year with BCE/CE notation
     */
    protected function formatYear(int $year): string
    {
        if ($year < 0) {
            return abs($year) . ' BCE';
        }
        return (string) $year;
    }
}
