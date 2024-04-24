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
        Schema::create('tupad_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('captain_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->integer('slot_get')->nullable();
            $table->integer('slot_left')->nullable();
            $table->string('month_year_available')->nullable();
            $table->date('date_obtained')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tupad_slots');
    }
};
