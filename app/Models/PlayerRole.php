<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->belongsToMany(Game::class, '3_pivot_game_player_role', 'player_role_id', 'game_id')
                    ->withTimestamps();
    }

    public function alternativeNames(): HasMany
    {
        return $this->hasMany(AlternativeName::class, 'vocabulary_id')
                    ->where('vocabulary_type', 'player_role');
    }
}
