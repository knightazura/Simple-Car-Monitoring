<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyFieldIntoHistoryCarUsage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_car_usages', function (Blueprint $table) {
            $table->string('driver_company')->after('driver');
            $table->string('backup_driver_company')->after('backup_driver');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history_car_usages', function (Blueprint $table) {
            $table->dropColumn(['driver_company', 'backup_driver_company']);
        });
    }
}
