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
        Schema::table('users', function (Blueprint $table) {
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->integer('age')->nullable();
            $table->string('sex')->nullable();
            $table->date('birthday')->nullable();
            $table->bigInteger('contactnumber')->nullable();
            $table->string('province')->nullable();
            $table->string('municipality')->nullable();
            $table->string('barangay')->nullable();
            $table->renameColumn('name', 'username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('firstname');
            $table->dropColumn('middlename');
            $table->dropColumn('lastname');
            $table->dropColumn('age');
            $table->dropColumn('sex');
            $table->dropColumn('birthday');
            $table->dropColumn('contactnumber');
            $table->dropColumn('province');
            $table->dropColumn('municipality');
            $table->dropColumn('barangay');
            $table->renameColumn('username', 'name');
        });
    }
};
