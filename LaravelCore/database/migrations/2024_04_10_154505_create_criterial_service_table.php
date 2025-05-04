<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriterialServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criterial_service', function (Blueprint $table) {
            $table->unsignedBigInteger('criterial_id');
            $table->unsignedBigInteger('service_id');
            $table->unique(['criterial_id','service_id']);

            $table->foreign('criterial_id')->references('id')->on('criterials')->cascadeOnDelete();
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
        Schema::dropIfExists('criterial_service');
    }
}
