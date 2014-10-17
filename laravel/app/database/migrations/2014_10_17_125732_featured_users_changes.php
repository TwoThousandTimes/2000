<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FeaturedUsersChanges extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('featured_users',function(Blueprint $table) 
		{
			$table->text('exerpt');
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
		Schema::table('featured_users', function(Blueprint $table) {
			$table->dropColumn('exerpt');
		});
	}

}
