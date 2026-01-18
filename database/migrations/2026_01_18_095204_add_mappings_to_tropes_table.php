<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('2_tropes', function (Blueprint $table) {
            $table->enum('wikidata_mapping', ['exactMatch', 'closeMatch', 'broadMatch', 'narrowMatch', 'relatedMatch'])->nullable()->after('wikidata_id');
            $table->enum('tvtropes_mapping', ['exactMatch', 'closeMatch', 'broadMatch', 'narrowMatch', 'relatedMatch'])->nullable()->after('tvtropes_url');
        });
    }

    public function down(): void
    {
        Schema::table('2_tropes', function (Blueprint $table) {
            $table->dropColumn(['wikidata_mapping', 'tvtropes_mapping']);
        });
    }
};
