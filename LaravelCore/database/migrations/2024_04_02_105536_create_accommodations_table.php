<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_id');
            $table->unsignedBigInteger('assistant_id');
            $table->unsignedBigInteger('pet_id');
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('company_id');
            $table->text('accessories')->comment('Phụ kiện kèm theo')->nullable();
            $table->text('details')->comment('Các chi tiết')->nullable();
            $table->unsignedTinyInteger('status')->comment('0: waiting; 1: complete')->default(0);
            $table->dateTime('checkin_at');
            $table->dateTime('estimate_checkout_at')->nullable();
            $table->dateTime('real_checkout_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('detail_id')->references('id')->on('details')->onDelete('cascade');
            $table->foreign('assistant_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('pet_id')->references('id')->on('pets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accommodations');
    }
}
