<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFuelStatusFieldToCarUsage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('car_usages', function (Blueprint $table) {
            $table->string('fuel_status')->after('usage_time')->nullable();
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
            $table->dropColumn('fuel_status');
        });
    }
}
