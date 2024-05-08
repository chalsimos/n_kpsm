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
        Schema::table('educational_assistances', function (Blueprint $table) {
            $table->string('student_email')->unique();
            $table->string('code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('educational_assistances', function (Blueprint $table) {
            $table->dropColumn('student_email');
            $table->dropColumn('code');
        });
    }
};
