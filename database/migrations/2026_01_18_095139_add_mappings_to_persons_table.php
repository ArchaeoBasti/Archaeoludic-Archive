<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('2_persons', function (Blueprint $table) {
            $table->enum('gnd_mapping', ['exactMatch', 'closeMatch', 'broadMatch', 'narrowMatch', 'relatedMatch'])->nullable()->after('gnd_id');
            $table->enum('wikidata_mapping', ['exactMatch', 'closeMatch', 'broadMatch', 'narrowMatch', 'relatedMatch'])->nullable()->after('wikidata_id');
        });
    }

    public function down(): void
    {
        Schema::table('2_persons', function (Blueprint $table) {
            $table->dropColumn(['gnd_mapping', 'wikidata_mapping']);
        });
    }
};
