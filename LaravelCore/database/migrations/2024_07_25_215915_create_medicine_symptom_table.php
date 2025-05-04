<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicineSymptomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicine_symptom', function (Blueprint $table) {
            $table->unsignedBigInteger('medicine_id');
            $table->unsignedBigInteger('symptom_id');
            $table->unique(['medicine_id','symptom_id']);
            
            $table->foreign('medicine_id')->references('id')->on('medicines')->cascadeOnDelete();
            $table->foreign('symptom_id')->references('id')->on('symptoms')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicine_symptom');
    }
}
