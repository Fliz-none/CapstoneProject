<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medicine_id');
            $table->string('dosage');
            $table->unsignedInteger('frequency');
            $table->string('route', 191);
            $table->unsignedInteger('quantity');
            $table->string('specie', 191);
            $table->unsignedInteger('age')->nullable();
            $table->unsignedDouble('weight')->nullable();
            $table->foreign('medicine_id')->references('id')->on('medicines')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dosages');
    }
}
