<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyDirectorFieldToHistoryCarUsages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_car_usages', function (Blueprint $table) {
            $table->string('company_director')->after('driver_company');
            $table->string('backup_company_director')->after('backup_driver_company');
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
            $table->dropColumn('company_director');
        });
    }
}
