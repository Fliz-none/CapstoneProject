<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('import_id');
            $table->unsignedBigInteger('variable_id');
            $table->unsignedBigInteger('unit_id');
            $table->bigInteger('quantity');
            $table->decimal('price', 10, 0)->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('variable_id')->references('id')->on('variables');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('import_id')->references('id')->on('imports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('import_details');
    }
}
