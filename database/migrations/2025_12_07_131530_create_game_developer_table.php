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
         Schema::create('1_game_developer', function (Blueprint $table) {
             $table->id();
             $table->unsignedBigInteger('game_id');
             $table->unsignedBigInteger('developer_id');
             $table->timestamps();

             $table->unique(['game_id', 'developer_id']);
         });
     }

    /**
     * Reverse the migrations.
     */
     public function down(): void
     {
         Schema::dropIfExists('1_game_developer');
     }
};
