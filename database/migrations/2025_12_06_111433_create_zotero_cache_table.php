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
      Schema::create('zotero_cache', function (Blueprint $table) {
          $table->string('item_key')->primary();
          $table->string('authors', 500)->nullable();
          $table->string('year', 20)->nullable();
          $table->string('citation', 600)->nullable();
          $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zotero_cache');
    }
};
