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
        Schema::create('secretariat', function (Blueprint $table) {
            $table->id();
            $table->integer('assessor_id')->nullable();
            $table->integer('application_id')->nullable();
            $table->integer('assessment_type')->nullable();
            $table->integer('status')->nullable();
            $table->string('due_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('secretariat');
    }
};
