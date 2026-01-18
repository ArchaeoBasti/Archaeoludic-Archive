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
        Schema::create('2_tropes', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique();
            $table->string('label_en');
            $table->text('description_en')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('2_tropes')->nullOnDelete();
            $table->string('tvtropes_url')->nullable();
            $table->string('wikidata_id')->nullable();
            $table->timestamps();

            $table->index('parent_id');
            $table->index('identifier');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('2_tropes');
    }
};
