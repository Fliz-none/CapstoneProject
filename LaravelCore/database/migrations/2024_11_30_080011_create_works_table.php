<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('branch_id');
            $table->string('shift_name');
            $table->dateTime('sign_checkin');
            $table->dateTime('real_checkin')->nullable();
            $table->string('image_checkin')->nullable();
            $table->dateTime('sign_checkout');
            $table->dateTime('real_checkout')->nullable();
            $table->string('image_checkout')->nullable();
            $table->unsignedInteger('serve_time')->default(0);
            $table->string('note')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('works');
    }
}
