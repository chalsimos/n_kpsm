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
        Schema::table('logos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('medical_requests', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('tupads', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('tupad_codes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('tupad_slots', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('medical_requests', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('tupads', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('tupad_codes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('tupad_slots', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};

