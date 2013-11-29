<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicingEntitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoicing_entities', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name');
            $table->string('surname');
            $table->string('commercial_name');
            $table->string('telephone1');
            $table->string('telephone2');
            $table->string('fax');
            $table->string('email');
            $table->string('business_id');
            $table->string('street1');
            $table->string('street2');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('country');
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
		Schema::drop('invoicing_entities');
	}

}
