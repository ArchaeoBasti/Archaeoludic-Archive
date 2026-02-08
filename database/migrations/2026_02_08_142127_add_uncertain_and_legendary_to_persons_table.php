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
        Schema::table('2_persons', function (Blueprint $table) {
            $table->boolean('birth_year_uncertain')->default(false)->after('birth_year');
            $table->boolean('death_year_uncertain')->default(false)->after('death_year');
            $table->boolean('legendary')->default(false)->after('death_year_uncertain');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('2_persons', function (Blueprint $table) {
            $table->dropColumn(['birth_year_uncertain', 'death_year_uncertain', 'legendary']);
        });
    }
};
