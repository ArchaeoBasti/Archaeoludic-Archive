<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('2_vocabulary_mappings');
    }

    public function down(): void
    {
        // Tabelle war leer, kein Rollback nötig
    }
};
