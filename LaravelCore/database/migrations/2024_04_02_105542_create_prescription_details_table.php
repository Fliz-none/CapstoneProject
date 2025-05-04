<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prescription_id');
            $table->unsignedBigInteger('medicine_id');
            $table->integer('quantity');
            $table->double('price', 10, 0)->default(0);
            $table->decimal('dosage', 8, 2)->nullable();
            $table->decimal('frequency', 8, 2)->nullable();
            $table->text('route')->nullable();
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('prescription_id')->references('id')->on('prescriptions');
            $table->foreign('medicine_id')->references('id')->on('medicines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescription_details');
    }
}
