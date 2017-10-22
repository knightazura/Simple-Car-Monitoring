<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryCarUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_car_usages', function (Blueprint $table) {
            $table->integer('usage_id')->unsigned();
            $table->string('employee');
            $table->string('employee_position');
            $table->string('employee_division');
            $table->string('car');
            $table->string('driver');
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
            $table->timestamp('original_created_date')->nullable();
            $table->timestamp('original_updated_date')->nullable();
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
        Schema::dropIfExists('history_car_usages');
    }
}
