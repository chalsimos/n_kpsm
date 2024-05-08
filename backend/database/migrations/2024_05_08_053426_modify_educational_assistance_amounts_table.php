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
        Schema::table('educational_assistance_amounts', function (Blueprint $table) {
            $table->renameColumn('vocational_college_amount', 'vocational_amount');
        });

        Schema::table('educational_assistance_amounts', function (Blueprint $table) {
            $table->unsignedBigInteger('college_amount')->nullable()->after('vocational_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('educational_assistance_amounts', function (Blueprint $table) {
            $table->renameColumn('vocational_amount', 'vocational_college_amount');
            $table->dropColumn('college_amount');
        });
    }
};
