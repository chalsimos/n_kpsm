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
        Schema::table('hospitals', function (Blueprint $table) {
            $table->renameColumn('hospital_address', 'province');
            $table->text('municipality')->nullable();
            $table->text('barangay')->nullable();
            $table->dropColumn('hospital_district');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->renameColumn('province', 'hospital_address');
            $table->dropColumn('municipality');
            $table->dropColumn('barangay');
            $table->text('hospital_district')->nullable();
        });
    }
};
