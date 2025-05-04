<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_id');
            $table->unsignedBigInteger('info_id');
            $table->unsignedBigInteger('export_id')->nullable();
            $table->string('ticket')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('detail_id')->references('id')->on('details');
            $table->foreign('info_id')->references('id')->on('infos');
            $table->foreign('export_id')->references('id')->on('exports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indications');
    }
}
