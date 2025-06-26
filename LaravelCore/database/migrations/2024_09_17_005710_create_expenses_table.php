<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedTinyInteger('payment')->comment('1: Cash; 2: Bank Transfer')->default(1);
            $table->unsignedDecimal('amount',10,2);
            $table->string('image')->nullable();
            $table->string('group')->nullable();
            $table->string('note')->nullable();
            $table->unsignedTinyInteger('status')->default(0)->comment('0:waiting; 1:accepted');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
