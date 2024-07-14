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
        Schema::create('budget_allocations', function (Blueprint $table) {
            $table->id();
            $table->text('total_budget')->nullable();
            $table->text('budget_left')->nullable();
            $table->text('total_expenses')->nullable();
            $table->text('budget_to_hospital')->nullable();
            $table->text('year')->nullable();
            $table->foreignId('added_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->text('status')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_allocations');
    }
};
