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
         Schema::table('zotero_cache', function (Blueprint $table) {
             $table->string('title', 500)->nullable()->after('citation');
             $table->string('publication', 500)->nullable()->after('title');
             $table->string('volume')->nullable()->after('publication');
             $table->string('issue')->nullable()->after('volume');
             $table->string('pages')->nullable()->after('issue');
             $table->string('publisher')->nullable()->after('pages');
             $table->string('place')->nullable()->after('publisher');
             $table->string('doi')->nullable()->after('place');
             $table->string('url', 1000)->nullable()->after('doi');
             $table->string('item_type')->nullable()->after('url');
         });
     }

    /**
     * Reverse the migrations.
     */
     public function down(): void
     {
         Schema::table('zotero_cache', function (Blueprint $table) {
             $table->dropColumn(['title', 'publication', 'volume', 'issue', 'pages', 'publisher', 'place', 'doi', 'url', 'item_type']);
         });
     }
};
