<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\State;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->unsigned()->nullable();
            $table->foreign('country_id')
            ->references('id')
            ->on('countries')
            ->onDelete('cascade');
            $table->string('code',4)->nullable();
            $table->string('name',50)->nullable();
            $table->double('latitude', 15, 8)->nullable();
            $table->double('longitude', 15, 8)->nullable();
            //  $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
