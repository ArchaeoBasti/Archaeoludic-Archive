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
         Schema::table('1_games', function (Blueprint $table) {
             $table->integer('igdb_id')->nullable()->after('wikidata_id');
         });
     }

    /**
     * Reverse the migrations.
     */
     public function down(): void
     {
         Schema::table('1_games', function (Blueprint $table) {
             $table->dropColumn('igdb_id');
         });
     }
};
