<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('name');
            $table->unsignedBigInteger('animal_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedTinyInteger('gender')->comment('0: different; 1: male; 2:female')->nullable();
            $table->date('birthday')->nullable();
            $table->string('avatar')->nullable();
            $table->string('fur_color')->nullable();
            $table->string('fur_type')->nullable();
            $table->text('vaccination')->nullable()->comment('Tiêm chủng định kỳ');
            $table->unsignedTinyInteger('neuter')->nullable()->comment('0: different; 1: no; 2: yes');
            $table->unsignedTinyInteger('status')->comment('0: block; 1: active')->default(1);
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('animal_id')->references('id')->on('animals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pets');
    }
}
