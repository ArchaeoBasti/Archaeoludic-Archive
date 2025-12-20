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
         Schema::table('igdb_cache', function (Blueprint $table) {
             $table->string('slug')->nullable()->after('igdb_id');
         });
     }

    /**
     * Reverse the migrations.
     */ 
     public function down(): void
     {
         Schema::table('igdb_cache', function (Blueprint $table) {
             $table->dropColumn('slug');
         });
     }
};
