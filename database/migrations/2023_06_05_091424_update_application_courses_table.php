<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_courses', function (Blueprint $table) {
            $table->integer('years')->nullable();
            $table->integer('months')->nullable();
            $table->integer('days')->nullable();
            $table->integer('hours')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('application_courses', function (Blueprint $table) {
            //
        });
    }
};
