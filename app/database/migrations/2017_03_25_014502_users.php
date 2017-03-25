<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table){
			$table->increments('id');
			$table->string('name', 60);
			$table->string('phone', 20);
			$table->string('email', 100)->index();
			$table->string('password', 100);
			$table->tinyInteger('type');
			$table->string('code', 20);
			$table->string('facebookId', 20)->index();
			$table->tinyInteger('state');
			$table->rememberToken();
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
		Schema::dropIfExists('users');
	}

}
