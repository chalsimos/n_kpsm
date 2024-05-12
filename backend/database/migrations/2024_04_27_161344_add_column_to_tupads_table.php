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
        Schema::table('tupads', function (Blueprint $table) {
            $table->foreignId('used_code_id')->nullable()->constrained('tupad_codes')->onDelete('cascade');
            $table->foreignId('given_by_captainID')->nullable()->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tupads', function (Blueprint $table) {
            $table->dropForeign(['used_code_id']);
            $table->dropColumn('used_code_id');
            $table->dropForeign(['given_by_captainID']);
            $table->dropColumn('given_by_captainID');
        });
    }
};
