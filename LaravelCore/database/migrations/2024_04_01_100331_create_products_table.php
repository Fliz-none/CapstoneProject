<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('name');
            $table->string('slug');
            $table->text('excerpt')->nullable();
            $table->longText('description')->nullable();
            $table->string('specs')->nullable();
            $table->string('keyword')->nullable();
            $table->text('gallery')->nullable();
            $table->unsignedInteger('sort')->nullable();
            $table->tinyInteger('allow_review')->coment('0: no; 1: yes')->default(1);
            $table->tinyInteger('status')->coment('0: block; 1: offline; 2: online; 3: featured')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}