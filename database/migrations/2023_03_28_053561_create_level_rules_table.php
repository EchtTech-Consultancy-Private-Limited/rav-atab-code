<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\LevelRule;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('level_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('level_id')->unsigned()->nullable();
            $table->foreign('level_id')
            ->references('id')
            ->on('levels')
            ->onDelete('cascade');
            $table->string('name',20)->nullable();
            $table->enum('rule_type', ['1','2','3','4','5'])->default(1); //'1'=>'Course fee','2'=>'One time app fee','3'=>'Assessment fee','4'=>'App renewal fee','5'=>'Assessor fee'
           // $table->enum('fee_duration', ['1','2','3','4','5','6','7','8'])->nullable()->change(); //'1'=>'Monthly','2'=>'Quarterly','3'=>'Half Yearly','4'=>'Yearly','5'=>'2 Yearly','6'=>'3 Yearly','7'=>'5 Yearly','8'=>'10 Yearly'
            $table->integer('fee_duration')->default(0); //in months
            $table->integer('course_criteria_more_than')->default(0);
            $table->integer('course_criteria_less_than_equal')->default(0);
            $table->integer('fee_india')->default(0);
            $table->integer('fee_saarc')->default(0);
            $table->integer('fee_rest_world')->default(0);
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level_rules');
    }
};
