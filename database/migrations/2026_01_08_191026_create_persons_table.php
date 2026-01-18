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
        Schema::create('2_persons', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique();
            $table->string('label_en');
            $table->text('description_en')->nullable();
            $table->string('gnd_id')->nullable();
            $table->string('wikidata_id')->nullable();
            $table->integer('birth_year')->nullable(); // Negative for BCE
            $table->integer('death_year')->nullable(); // Negative for BCE
            $table->timestamps();

            $table->index('identifier');
            $table->index('gnd_id');
            $table->index('wikidata_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('2_persons');
    }
};
