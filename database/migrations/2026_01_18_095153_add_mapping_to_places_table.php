<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('2_places', function (Blueprint $table) {
            $table->enum('tgn_mapping', ['exactMatch', 'closeMatch', 'broadMatch', 'narrowMatch', 'relatedMatch'])->nullable()->after('tgn_id');
        });
    }

    public function down(): void
    {
        Schema::table('2_places', function (Blueprint $table) {
            $table->dropColumn('tgn_mapping');
        });
    }
};
