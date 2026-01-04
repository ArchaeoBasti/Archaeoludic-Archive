<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PlayerRole extends Model
{
    protected $table = '2_player_roles';

    protected $fillable = [
        'identifier',
        'label_en',
        'description_en',
    ];

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, '1_game_player_role', 'player_role_id', 'game_id')
                    ->withTimestamps();
    }

    public function mappings(): MorphMany
    {
        return $this->morphMany(VocabularyMapping::class, 'concept');
    }
}
