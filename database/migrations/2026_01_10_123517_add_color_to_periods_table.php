<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('2_periods', function (Blueprint $table) {
            $table->string('color', 7)->nullable()->after('end_uncertain');
        });
    }

    public function down(): void
    {
        Schema::table('2_periods', function (Blueprint $table) {
            $table->dropColumn('color');
        });
    }
};
