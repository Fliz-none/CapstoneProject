<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->datetime('deadline');
            $table->string('domain');
            $table->decimal('contract_total', 10, 0)->default(0);
            $table->boolean('has_website')->default(0);
            $table->boolean('has_shop')->default(0);
            $table->boolean('has_warehouse')->default(0);
            $table->boolean('has_clinic')->default(0);
            $table->boolean('has_attendance')->default(0);
            $table->boolean('has_beauty')->default(0);
            $table->boolean('has_booking')->default(0);
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('tax_id')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->string('note')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
