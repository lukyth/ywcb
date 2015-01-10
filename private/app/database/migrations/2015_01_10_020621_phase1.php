<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Phase1 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tracks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->char('name', 255);
			$table->text('description');
			$table->char('file', 255)->nullable();
			$table->char('instrument', 255);
			$table->tinyInteger('permission')->default(0);
			$table->integer('user')->unsigned();
			$table->foreign('user')->references('id')->on('users');
			$table->timestamps();
			$table->softDeletes();
		});
		Schema::create('relations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_1');
			$table->integer('user_2');
			// $table->foreign('user_1')->references('id')->on('users');
			// $table->foreign('user_2')->references('id')->on('users');
			$table->timestamps();
		});
		Schema::create('track_rel', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('track_1');
			$table->integer('track_2');
			// $table->foreign('track_1')->references('id')->on('tracks');
			// $table->foreign('track_2')->references('id')->on('tracks');
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
		Schema::drop('relations');
		Schema::drop('tracks');
		Schema::drop('track_rel');
	}

}
