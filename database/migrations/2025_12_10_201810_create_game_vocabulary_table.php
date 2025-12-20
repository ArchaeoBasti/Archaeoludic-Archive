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
         Schema::create('1_game_vocabulary', function (Blueprint $table) {
             $table->id();
             $table->unsignedBigInteger('game_id');
             $table->string('voc_id', 10);
             $table->timestamps();

             $table->unique(['game_id', 'voc_id']);
         });
     }

    /**
     * Reverse the migrations.
     */
     public function down(): void
     {
         Schema::dropIfExists('1_game_vocabulary');
     }
};
