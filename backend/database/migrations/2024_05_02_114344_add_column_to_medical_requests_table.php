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
        Schema::table('medical_requests', function (Blueprint $table) {
            $table->text('valid_id_imagepath')->nullable();
            $table->text('hospital_document_imagepath')->nullable();
            $table->text('barangay_clearance_imagepath')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_requests', function (Blueprint $table) {
            $table->dropColumn('valid_id_imagepath');
            $table->dropColumn('hospital_document_imagepath');
            $table->dropColumn('barangay_clearance_imagepath');
        });
    }
};
