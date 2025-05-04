<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExportDetailIdToImportDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('import_details', function (Blueprint $table) {
            $table->unsignedBigInteger('export_detail_id')->nullable()->after('import_id');
            $table->foreign('export_detail_id')->references('id')->on('export_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('import_details', function (Blueprint $table) {
            $table->dropForeign(['export_detail_id']);
            $table->dropColumn('export_detail_id');
        });
    }
}
