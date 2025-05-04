<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pet_id');
            $table->unsignedBigInteger('detail_id');
            $table->unsignedBigInteger('accommodation_id')->nullable();
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('company_id');
            $table->text('generals')->comment('thông tin chung')->nullable();
            $table->text('symptoms')->comment('các triệu chứng')->nullable();
            $table->text('diags')->comment('các chẩn đoán')->nullable();
            $table->unsignedTinyInteger('form')->comment('1: phiếu khám, 2: tiêm ngừa; 3: làm đẹp')->default(1);
            $table->unsignedTinyInteger('type')->default(1)->comment('1: tại PK, 2: tại nhà, 3: online');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('accommodation_id')->references('id')->on('accommodations')->onDelete('cascade');
            $table->foreign('pet_id')->references('id')->on('pets');
            $table->foreign('detail_id')->references('id')->on('details');
            $table->foreign('doctor_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('infos');
    }
}
