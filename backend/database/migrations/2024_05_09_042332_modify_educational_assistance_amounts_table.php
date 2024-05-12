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
            $table->renameColumn('senior_highschool_amount', 'senior_high_school_amount');
            $table->renameColumn('highschool_amount', 'high_school_amount');
            $table->renameColumn('elemantary_amount', 'elementary_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('educational_assistance_amounts', function (Blueprint $table) {
            $table->renameColumn('senior_high_school_amount', 'senior_highschool_amount');
            $table->renameColumn('high_school_amount', 'highschool_amount');
            $table->renameColumn('elementary_amount', 'elemantary_amount');
        });
    }
};
