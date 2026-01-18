<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('1_game_period', '3_pivot_game_period');
        Schema::rename('1_game_place', '3_pivot_game_place');
        Schema::rename('1_game_gameplay_mode', '3_pivot_game_gameplay_mode');
        Schema::rename('1_game_player_role', '3_pivot_game_player_role');
        Schema::rename('1_game_trope', '3_pivot_game_trope');
        Schema::rename('1_game_person', '3_pivot_game_person');
    }

    public function down(): void
    {
        Schema::rename('3_pivot_game_period', '1_game_period');
        Schema::rename('3_pivot_game_place', '1_game_place');
        Schema::rename('3_pivot_game_gameplay_mode', '1_game_gameplay_mode');
        Schema::rename('3_pivot_game_player_role', '1_game_player_role');
        Schema::rename('3_pivot_game_trope', '1_game_trope');
        Schema::rename('3_pivot_game_person', '1_game_person');
    }
};
