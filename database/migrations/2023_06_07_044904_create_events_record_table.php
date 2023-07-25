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
        Schema::create('events_record', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('start');
            $table->date('end');
            $table->string('add_event_descp')->nullable();
            $table->integer('asesrar_id')->nullable();
            $table->date('available_date')->nullable();
            $table->integer('availability')->nullable();
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
        Schema::dropIfExists('events_record');
    }
};
