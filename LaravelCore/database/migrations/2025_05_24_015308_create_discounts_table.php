<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id');
            $table->string('name');
            $table->unsignedTinyInteger('type')->comment('0: percent, 1: fixed, 2: buy_x_get_y');
            $table->enum('apply_type', ['once', 'multiple'])->default('once');

            // Giá trị giảm: % hoặc số tiền
            $table->unsignedDecimal('value', 10, 0)->nullable();

            // Mua X tặng Y
            $table->unsignedInteger('buy_quantity')->nullable();
            $table->unsignedInteger('get_quantity')->nullable();

            // Áp dụng khi mua tối thiểu bao nhiêu sản phẩm
            $table->unsignedInteger('min_quantity')->default(1);

            // Thời gian áp dụng
            $table->date('start_date');
            $table->date('end_date');


            $table->unsignedTinyInteger('status')->default(1)->comment('0: block; 1: active');

            $table->softDeletes();
            $table->timestamps();

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
        Schema::dropIfExists('discounts');
    }
}
