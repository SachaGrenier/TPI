<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		
		//MSP
		Schema::create('msp', function (Blueprint $table) {
			$table->increments('id');
            $table->string('firstname');
			$table->string('lastname');
			$table->string('initials',4);
        });
		//color
        Schema::create('color', function (Blueprint $table) {
			$table->increments('id');
            $table->string('name');
			$table->string('hex');
        });
				
		//workshop_level_1
		Schema::create('workshop_level_1', function (Blueprint $table) {
			$table->increments('id');
            $table->string('name');
			$table->integer('color_id')->unsigned();
			$table->foreign('color_id')->references('id')->on('color');
        });
		
		//workshop_level_2
		Schema::create('workshop_level_2', function (Blueprint $table) {
			$table->increments('id');
            $table->string('name');
			$table->integer('workshop_level_1_id')->unsigned();
			$table->foreign('workshop_level_1_id')->references('id')->on('workshop_level_1');
        });
		
		//workshop_level_3
		Schema::create('workshop_level_3', function (Blueprint $table) {
			$table->increments('id');
            $table->string('name');
			$table->integer('workshop_level_2_id')->unsigned();
			$table->foreign('workshop_level_2_id')->references('id')->on('workshop_level_2');
        });
		
		//worker
		Schema::create('worker', function (Blueprint $table) {
			$table->increments('id');
            $table->string('firstname');
			$table->string('lastname');
			$table->string('username');
			$table->integer('percentage');
			$table->timestamps();
			$table->integer('msp_id')->unsigned();
			$table->foreign('msp_id')->references('id')->on('msp');
        });
		//task
		   Schema::create('task', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('worker_id')->unsigned();
			$table->integer('workshop_level_3_id')->unsigned();
			$table->boolean('isMorning');
			$table->date('date');
			$table->foreign('worker_id')->references('id')->on('worker');
			$table->foreign('workshop_level_3_id')->references('id')->on('workshop_level_3');
        });
		
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
