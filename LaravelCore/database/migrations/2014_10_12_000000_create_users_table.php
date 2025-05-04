<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('avatar')->nullable();
            $table->unsignedTinyInteger('gender')->comment('0:male; 1:female; 2:other')->default(0);
            $table->string('password')->nullable();
            $table->date('birthday')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('local_id')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedDecimal('debt', 10, 0)->default(0);
            $table->string('scores')->nullable();
            $table->unsignedTinyInteger('level')->default(0);
            $table->unsignedTinyInteger('status')->comment('0:block; 1:active')->default(1);
            $table->dateTime('last_login_at')->nullable();
            $table->text('note')->nullable();

            $table->dateTime('email_verified_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->constrained()->onDelete('restrict');
            $table->foreign('local_id')->references('id')->on('locals')->constrained()->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
