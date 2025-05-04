<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trackings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accommodation_id');
            $table->unsignedBigInteger('assistant_id');
            $table->text('parameters');
            $table->text('images')->nullable();
            $table->string('score')->default();
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('accommodation_id')->references('id')->on('accommodations');
            $table->foreign('assistant_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trackings');
    }
}
