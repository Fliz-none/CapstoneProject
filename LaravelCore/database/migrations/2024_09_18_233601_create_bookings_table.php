<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('pet_id')->nullable();
            $table->unsignedSmallInteger('frequency')->default(0);
            $table->dateTime('appointment_at');
            $table->dateTime('remind_at');
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedBigInteger('company_id');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('author_id')->references('id')->on('users');
            $table->foreign('doctor_id')->references('id')->on('users');
            $table->foreign('pet_id')->references('id')->on('pets');
            $table->foreign('service_id')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
