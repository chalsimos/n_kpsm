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
        Schema::create('tupad_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('captain_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('slot_id')->nullable()->constrained('tupad_slots')->onDelete('cascade');
            $table->string('code_generated')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tupad_codes');
    }
};
