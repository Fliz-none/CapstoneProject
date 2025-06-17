<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('logs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('action');       // thao tác: create, update, delete
        $table->string('type');         // loại đối tượng: user, product,...
        $table->string('object');       // ID đối tượng
        $table->text('before_change')->nullable(); // thêm
        $table->text('after_change')->nullable();  // thêm
        $table->text('geolocation');
        $table->string('agent');
        $table->string('platform');
        $table->string('device');
      
        $table->timestamps();
        
        $table->foreign('user_id')->references('id')->on('users');
    }  );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
