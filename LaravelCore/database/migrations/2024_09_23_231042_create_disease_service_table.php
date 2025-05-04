<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiseaseServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disease_service', function (Blueprint $table) {
            $table->unsignedBigInteger('disease_id');
            $table->unsignedBigInteger('service_id');
            $table->unique(['disease_id','service_id']);

            $table->foreign('disease_id')->references('id')->on('diseases')->cascadeOnDelete();
            $table->foreign('service_id')->references('id')->on('services')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disease_service');
    }
}
