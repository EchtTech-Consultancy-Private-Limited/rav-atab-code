<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ApplicationPayment;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('application_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('application_id')->unsigned()->nullable();
            $table->foreign('application_id')
            ->references('id')
            ->on('applications')
            ->onDelete('cascade');
            $table->integer('level_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->integer('amount')->default(0);
            $table->timestamp('payment_date')->nullable();
            $table->string('payment_details',255)->nullable();
            $table->string('payment_details_file',64)->nullable();
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_to')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_payments');
    }
};
