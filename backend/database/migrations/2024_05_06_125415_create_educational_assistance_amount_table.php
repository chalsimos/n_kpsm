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
        Schema::create('educational_assistance_amount', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('elemantary_amount')->nullable();
            $table->unsignedBigInteger('highschool_amount')->nullable();
            $table->unsignedBigInteger('senior_highschool_amount')->nullable();
            $table->unsignedBigInteger('vocational_college_amount')->nullable();
            $table->unsignedBigInteger('total_target')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_assistance_amount');
    }
};
