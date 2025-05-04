<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('stock_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedInteger('quantity');
            $table->unsignedDouble('price', 10, 0)->default(0);
            $table->decimal('discount', 10, 0)->nullable();
            $table->string('note')->nullable();
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->foreign('service_id')->references('id')->on('services');
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
        Schema::dropIfExists('details');
    }
}
