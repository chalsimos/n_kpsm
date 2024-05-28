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
        Schema::create('captain_tupad_excel_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tupad_code_id')->nullable()->constrained('tupad_codes')->onDelete('cascade');
            $table->foreignId('given_by_captainID')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('tupad_slot_id')->nullable()->constrained('tupad_slots')->onDelete('cascade');
            $table->text('excel_path')->nullable();
            $table->text('images_path')->nullable();
            $table->string('status')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('captain_tupad_excel_forms');
    }
};
