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
        // Drop old pivot table first (due to potential constraints)
        Schema::dropIfExists('1_game_vocabulary');

        // Drop old vocabulary table
        Schema::dropIfExists('2_vocabulary');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate old vocabulary table
        Schema::create('2_vocabulary', function (Blueprint $table) {
            $table->string('voc_id', 10)->primary();
            $table->string('term');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->timestamps();
        });

        // Recreate old pivot table
        Schema::create('1_game_vocabulary', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id');
            $table->string('voc_id', 10);
            $table->timestamps();

            $table->unique(['game_id', 'voc_id']);
        });
    }
};
