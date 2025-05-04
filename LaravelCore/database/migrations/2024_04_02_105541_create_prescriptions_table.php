<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('indication_id')->nullable();
            $table->unsignedBigInteger('info_id')->nullable();
            $table->unsignedBigInteger('detail_id')->nullable();
            $table->unsignedBigInteger('export_id')->nullable();
            $table->unsignedBigInteger('pharmacist_id')->comment('Người phát thuốc')->nullable();
            $table->string('name')->nullable();
            $table->text('message')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('indication_id')->references('id')->on('indications');
            $table->foreign('detail_id')->references('id')->on('details');
            $table->foreign('info_id')->references('id')->on('infos');
            $table->foreign('export_id')->references('id')->on('exports');
            $table->foreign('pharmacist_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescriptions');
    }
}
