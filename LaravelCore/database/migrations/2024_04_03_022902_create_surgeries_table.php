<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurgeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surgeries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('indication_id')->nullable();
            $table->unsignedBigInteger('info_id')->nullable();
            $table->unsignedBigInteger('detail_id')->nullable();
            $table->unsignedBigInteger('surgeon_id')->comment('BS Phẫu thuật')->nullable();
            $table->unsignedBigInteger('assistant_id')->comment('Phụ tá')->nullable();
            $table->unsignedBigInteger('anesthetist_id')->comment('BS gây mê')->nullable();
            $table->string('surgical_method')->comment('PP Phẫu thuật')->nullable();
            $table->string('anesthesia_method')->comment('PP Gây mê')->nullable();
            $table->text('diagram')->nullable();
            $table->text('details')->nullable()->comment('criterial_id, 10mins, 30mins, 60mins, 120mins, 180mins, 210mins, 240mins');
            $table->dateTime('begin_at')->nullable();
            $table->dateTime('complete_at')->nullable();
            $table->text('images_before')->nullable();
            $table->text('images_after')->nullable();
            $table->text('advice')->nullable();
            $table->unsignedTinyInteger('status')->comment('0: waiting; 1: complete')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('indication_id')->references('id')->on('indications');
            $table->foreign('info_id')->references('id')->on('infos');
            $table->foreign('detail_id')->references('id')->on('details');
            $table->foreign('surgeon_id')->references('id')->on('users');
            $table->foreign('assistant_id')->references('id')->on('users');
            $table->foreign('anesthetist_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surgeries');
    }
}
