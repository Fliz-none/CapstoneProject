<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->unsignedBigInteger('variable_id');
            $table->text('contraindications')->nullable();
            $table->text('sample_dosages')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('variable_id')->references('id')->on('variables')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicines');
    }
}
