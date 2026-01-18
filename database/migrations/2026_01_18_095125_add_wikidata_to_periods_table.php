<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('2_periods', function (Blueprint $table) {
            $table->string('wikidata_id')->nullable()->after('color');
            $table->enum('wikidata_mapping', ['exactMatch', 'closeMatch', 'broadMatch', 'narrowMatch', 'relatedMatch'])->nullable()->after('wikidata_id');
        });
    }

    public function down(): void
    {
        Schema::table('2_periods', function (Blueprint $table) {
            $table->dropColumn(['wikidata_id', 'wikidata_mapping']);
        });
    }
};
