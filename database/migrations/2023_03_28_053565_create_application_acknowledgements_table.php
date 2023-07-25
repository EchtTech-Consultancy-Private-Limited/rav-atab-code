<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ApplicationAcknowledgement;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('application_acknowledgements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('application_id')->unsigned()->nullable();
            $table->foreign('application_id')
            ->references('id')
            ->on('applications')
            ->onDelete('cascade');
            $table->integer('level_id')->default(0);
            $table->bigInteger('user_id')->default(0);
            $table->string('subject',255)->nullable();
            $table->text('description')->nullable();
            $table->integer('send_email_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_acknowledgements');
    }
};
