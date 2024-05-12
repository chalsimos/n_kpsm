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
        Schema::create('educational_assistances', function (Blueprint $table) {
            $table->id();
            $table->string('representative_lastname')->nullable();
            $table->string('representative_firstname')->nullable();
            $table->string('representative_middlename')->nullable();
            $table->date('representative_birthday')->nullable();
            $table->string('representative_gender')->nullable();
            $table->integer('representative_age')->nullable();
            $table->string('beneficiary_lastname')->nullable();
            $table->string('beneficiary_firstname')->nullable();
            $table->string('beneficiary_middlename')->nullable();
            $table->date('beneficiary_birthday')->nullable();
            $table->integer('beneficiary_age')->nullable();
            $table->string('beneficiary_gender')->nullable();
            $table->string('relationship_to_beneficiary')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('province')->nullable();
            $table->string('municipality')->nullable();
            $table->string('barangay')->nullable();
            $table->string('sitio')->nullable();
            $table->string('school')->nullable();
            $table->string('school_level')->nullable();
            $table->string('year_level')->nullable();
            $table->string('academic_year_stage')->nullable();
            $table->string('remarks')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_assistances');
    }
};
