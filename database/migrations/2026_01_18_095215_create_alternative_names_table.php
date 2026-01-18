<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('3_alternative_names', function (Blueprint $table) {
            $table->id();
            $table->string('vocabulary_type'); // period, place, person, trope, gameplay_mode, player_role
            $table->unsignedBigInteger('vocabulary_id');
            $table->string('name');
            $table->string('language', 10)->default('en'); // en, de, la, etc.
            $table->timestamps();

            $table->index(['vocabulary_type', 'vocabulary_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('3_alternative_names');
    }
};
