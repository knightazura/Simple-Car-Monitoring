<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBackupDriverIDFieldToHistoryCarUsage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_car_usages', function (Blueprint $table) {
            $table->string('backup_driver')->after('driver')->nullable();
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
            $table->dropColumn('backup_driver');
        });
    }
}
