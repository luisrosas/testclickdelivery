<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserPrivileges extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_privileges', function($table){
			$table->increments('id');
			$table->integer('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->boolean('view')->default(0);
			$table->boolean('edit')->default(0);
			$table->boolean('delete')->default(0);
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
		Schema::dropIfExists('user_privileges');
	}

}
