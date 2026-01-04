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
        Schema::create('2_vocabulary_mappings', function (Blueprint $table) {
            $table->id();
            $table->string('concept_type'); // 'period', 'place', 'gameplay_mode', 'player_role'
            $table->unsignedBigInteger('concept_id');
            $table->string('match_type'); // exactMatch, broadMatch, narrowMatch, closeMatch, relatedMatch
            $table->string('external_uri');
            $table->string('external_source'); // wikidata, periodo, getty-aat, geonames, etc.
            $table->timestamps();

            $table->index(['concept_type', 'concept_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('2_vocabulary_mappings');
    }
};
