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
            $table->dropColumn([
                'firstname',
                'middlename',
                'lastname',
                'age',
                'birthday',
                'gender',
                'civil_status',
                'contact_number',
                'benificiary_name',
                'id_type',
                'id_number',
                'status',
                'sitio',
                'decline_reason',
                'address',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tupads', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->string('decline_reason')->nullable();
            $table->string('sitio')->nullable();
            $table->string('status')->nullable();
            $table->string('id_number')->nullable();
            $table->string('id_type')->nullable();
            $table->string('benificiary_name')->nullable();
            $table->bigInteger('contact_number')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('gender')->nullable();
            $table->string('birthday')->nullable();
            $table->bigInteger('age')->nullable();
            $table->string('lastname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('firstname')->nullable();
        });
    }
};
