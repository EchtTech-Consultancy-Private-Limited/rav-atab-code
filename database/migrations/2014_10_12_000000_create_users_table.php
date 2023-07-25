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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',8);
            $table->string('firstname',32);
            $table->string('middlename',32)->nullable();
            $table->string('lastname',32)->nullable();
            $table->string('gender',8)->nullable();
            $table->string('organization',32)->nullable();
            $table->string('designation',32)->nullable();
            $table->string('email',50)->unique();
            $table->string('password',255);
            $table->string('phone_no',20)->nullable();
            $table->string('mobile_no',10)->nullable();
            $table->string('address',50)->nullable();
            $table->integer('city')->nullable();
            $table->integer('state')->nullable();
            $table->integer('country')->nullable();
            $table->string('postal',8)->nullable();
            $table->integer('status')->default(0);
            $table->string('about',255)->nullable();
            $table->enum('role', ['1','2','3','4'])->default(1); //'1'=>'Admin','2'=>'TP','3'=>'Assessor,'4'=>'Professionals'
            $table->string('last_login_ip',12)->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
