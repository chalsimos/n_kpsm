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
            $table->text('valid_id_imagepath')->nullable();
            $table->text('certificate_of_registration_imagepath')->nullable();
            $table->text('certificate_of_enrollment_imagepath')->nullable();
            $table->text('barangay_indigency_imagepath')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('educational_assistances', function (Blueprint $table) {
            $table->dropColumn('valid_id_imagepath');
            $table->dropColumn('certificate_of_registration_imagepath');
            $table->dropColumn('certificate_of_enrollment_imagepath');
            $table->dropColumn('barangay_indigency_imagepath');
        });
    }
};
