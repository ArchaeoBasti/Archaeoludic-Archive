<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Game <-> Period
        Schema::create('1_game_period', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('period_id');
            $table->timestamps();

            $table->unique(['game_id', 'period_id']);

            $table->foreign('period_id')
                  ->references('id')
                  ->on('2_periods')
                  ->onDelete('cascade');
        });

        // Game <-> Place
        Schema::create('1_game_place', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('place_id');
            $table->timestamps();

            $table->unique(['game_id', 'place_id']);

            $table->foreign('place_id')
                  ->references('id')
                  ->on('2_places')
                  ->onDelete('cascade');
        });

        // Game <-> Gameplay Mode
        Schema::create('1_game_gameplay_mode', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('gameplay_mode_id');
            $table->timestamps();

            $table->unique(['game_id', 'gameplay_mode_id']);

            $table->foreign('gameplay_mode_id')
                  ->references('id')
                  ->on('2_gameplay_modes')
                  ->onDelete('cascade');
        });

        // Game <-> Player Role
        Schema::create('1_game_player_role', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('player_role_id');
            $table->timestamps();

            $table->unique(['game_id', 'player_role_id']);

            $table->foreign('player_role_id')
                  ->references('id')
                  ->on('2_player_roles')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('1_game_player_role');
        Schema::dropIfExists('1_game_gameplay_mode');
        Schema::dropIfExists('1_game_place');
        Schema::dropIfExists('1_game_period');
    }
};
