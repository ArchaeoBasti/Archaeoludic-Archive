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
         Schema::create('igdb_cache', function (Blueprint $table) {
             $table->id();
             $table->string('game_title')->index();
             $table->integer('igdb_id')->nullable();
             $table->text('description')->nullable();
             $table->string('cover_url')->nullable();
             $table->string('genres')->nullable();
             $table->string('platforms', 1000)->nullable();
             $table->string('developers')->nullable();
             $table->string('publishers')->nullable();
             $table->timestamps();
         });
     }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('igdb_cache');
    }
};
