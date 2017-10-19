<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_usages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nip', 64);
            $table->string('car_plat_number', 10);
            $table->integer('driver_id')->unsigned();
            $table->tinyInteger('total_passengers')->unsigned()->nullable();
            $table->string('destination')->nullable();
            $table->mediumText('necessity')->nullable();
            $table->timestamp('desire_time')->nullable();
            $table->smallInteger('estimates_time')->unsigned()->nullable();
            $table->timestamp('start_use')->nullable();
            $table->string('start_km_pos')->nullable();
            $table->timestamp('end_use')->nullable();
            $table->string('end_km_pos')->nullable();
            $table->string('usage_time')->nullable();
            $table->mediumText('additional_description')->nullable();
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
        Schema::dropIfExists('car_usages');
    }
}
