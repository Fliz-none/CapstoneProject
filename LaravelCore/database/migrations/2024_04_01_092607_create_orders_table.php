<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('dealer_id')->nullable();
            $table->unsignedTinyInteger('method')->nullable();
            $table->unsignedDecimal('total', 10, 0)->default(0);
            $table->unsignedDecimal('discount', 10, 0)->default(0);
            $table->unsignedTinyInteger('status')->comment('0: complete; 1: waiting 2:cancel')->default(1);
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('dealer_id')->references('id')->on('users');
            $table->foreign('branch_id')->references('id')->on('branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
