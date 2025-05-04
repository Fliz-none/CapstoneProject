<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeautiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beauties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('info_id')->nullable();
            $table->unsignedBigInteger('detail_id');
            $table->unsignedBigInteger('technician_id')->comment('Kỹ thuật viên')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->dateTime('checkin_at')->nullable();
            $table->dateTime('checkout_at')->nullable();
            $table->text('details')->nullable();
            $table->unsignedTinyInteger('status')->comment('0: waiting; 1: complete')->default(0);
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('info_id')->references('id')->on('infos');
            $table->foreign('detail_id')->references('id')->on('details');
            $table->foreign('technician_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beauties');
    }
}
