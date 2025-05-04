<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExportDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('export_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_id');
            $table->unsignedBigInteger('export_id');
            $table->unsignedBigInteger('detail_id')->nullable();
            $table->decimal('quantity',8,2)->default(0);
            $table->unsignedBigInteger('unit_id');
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->foreign('export_id')->references('id')->on('exports');
            $table->foreign('detail_id')->references('id')->on('details');
            $table->foreign('unit_id')->references('id')->on('units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('export_details');
    }
}
