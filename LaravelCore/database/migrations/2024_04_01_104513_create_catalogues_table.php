<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCataloguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogues', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->unsignedInteger('sort')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('is_featured')->default(false)->comment('0: no; 1: yes');
            $table->unsignedTinyInteger('status')->coment('0: block; 1: active')->default(1);
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('catalogues');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalogues');
    }
}
