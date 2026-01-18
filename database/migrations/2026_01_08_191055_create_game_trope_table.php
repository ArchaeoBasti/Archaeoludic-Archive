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
        Schema::create('1_game_trope', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id');
            $table->foreignId('trope_id')->constrained('2_tropes')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['game_id', 'trope_id']);
            $table->index('game_id');
            $table->index('trope_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('1_game_trope');
    }
};
