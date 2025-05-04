<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->unsignedBigInteger('major_id')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedTinyInteger('is_indicated')->comment('Chỉ định')->default(0);
            $table->unsignedTinyInteger('commitment_required')->comment('Cam kết')->default(0);
            $table->text('commitment_note')->nullable();
            $table->string('ticket', 125)->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('description')->nullable();
            $table->text('keyword')->nullable();
            $table->text('consumables')->nullable();
            $table->unsignedDouble('price', 10, 0)->default(0);
            $table->string('unit')->nullable();
            $table->unsignedDouble('commission', 10, 0)->default(0);
            $table->string('avatar')->nullable();
            $table->unsignedInteger('sort')->nullable();
            $table->tinyInteger('status')->coment('0: block; 1: active')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('major_id')->references('id')->on('majors')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
