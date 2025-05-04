<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiseaseMedicineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disease_medicine', function (Blueprint $table) {
            $table->unsignedBigInteger('disease_id');
            $table->unsignedBigInteger('medicine_id');
            $table->unique(['disease_id','medicine_id']);

            $table->foreign('disease_id')->references('id')->on('diseases')->cascadeOnDelete();
            $table->foreign('medicine_id')->references('id')->on('medicines')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disease_medicine');
    }
}
