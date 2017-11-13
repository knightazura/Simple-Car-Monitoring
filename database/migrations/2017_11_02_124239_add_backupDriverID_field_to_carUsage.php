<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBackupDriverIDFieldToCarUsage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('car_usages', function (Blueprint $table) {
            $table->integer('backup_driver_id')->after('driver_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('car_usages', function (Blueprint $table) {
            $table->dropColumn('backup_driver_id');
        });
    }
}
