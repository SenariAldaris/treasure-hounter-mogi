<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitpayTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('unitpay', function(Blueprint $table)
		{
            $table->increments('id');
		    $table->string('unitpayId');
		    $table->string('account');
		    $table->float('sum');
		    $table->integer('itemsCount');
		    $table->timestamp('dateCreate');
		    $table->timestamp('dateComplete');
		    $table->tinyInteger('status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('unitpay');
	}

}
