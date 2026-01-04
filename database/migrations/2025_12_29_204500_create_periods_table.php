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
        Schema::create('2_periods', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique();
            $table->string('label_en');
            $table->text('description_en')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('start_year')->nullable(); // negative for BCE
            $table->integer('end_year')->nullable();   // negative for BCE
            $table->boolean('start_uncertain')->default(false);
            $table->boolean('end_uncertain')->default(false);
            $table->timestamps();

            $table->foreign('parent_id')
                  ->references('id')
                  ->on('2_periods')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('2_periods');
    }
};
