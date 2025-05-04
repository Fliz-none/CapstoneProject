<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('term',191);
            $table->unsignedBigInteger('variable_id');
            $table->unsignedInteger('rate');
            $table->string('barcode')->nullable();
            $table->decimal('price', 10, 0)->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('variable_id')->references('id')->on('variables');
            $table->unique(['barcode', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
}
