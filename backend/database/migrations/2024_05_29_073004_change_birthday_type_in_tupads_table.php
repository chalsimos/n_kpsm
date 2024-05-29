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
            $table->string('birthday')->nullable()->change();
            $table->bigInteger('contact_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tupads', function (Blueprint $table) {
            $table->date('birthday')->nullable()->change();
            $table->integer('contact_number')->nullable()->change();
        });
    }
};
