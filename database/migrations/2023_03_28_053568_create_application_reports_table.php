<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ApplicationReport;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('application_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('application_id')->unsigned()->nullable();
            $table->foreign('application_id')
            ->references('id')
            ->on('applications')
            ->onDelete('cascade');
            $table->integer('level_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->integer('document_type_id')->unsigned()->nullable();
            $table->foreign('document_type_id')
            ->references('id')
            ->on('document_types')
            ->onDelete('cascade');
            $table->string('document_file',64)->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_reports');
    }
};
