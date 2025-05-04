<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiseasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diseases', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('infection_chain', 255)->comment('ủ bệnh & lây lan')->nullable();
            $table->text('counsel', 255)->comment('tư vấn')->nullable();
            $table->text('complication', 255)->comment('biến chứng')->nullable();
            $table->text('prevention', 255)->comment('phòng ngừa')->nullable();
            $table->text('advice', 255)->comment('lời dặn')->nullable();
            $table->text('prognosis', 255)->comment('tiên lượng')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diseases');
    }
}
