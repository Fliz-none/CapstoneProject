<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuicktestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quicktests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('indication_id')->nullable();
            $table->unsignedBigInteger('info_id')->nullable();
            $table->unsignedBigInteger('detail_id')->nullable();
            $table->unsignedBigInteger('technician_id')->comment('Kỹ thuật viên')->nullable();
            $table->string('sample')->nullable();
            $table->string('method')->nullable();
            $table->text('recommendation')->nullable();
            $table->text('conclusion')->nullable();
            $table->text('images')->nullable();
            $table->unsignedTinyInteger('status')->comment('0: waiting; 1: complete')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('indication_id')->references('id')->on('indications');
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
        Schema::dropIfExists('quicktests');
    }
}
