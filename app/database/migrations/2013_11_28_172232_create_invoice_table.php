<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoices', function(Blueprint $table)
		{
			$table->increments('id');
            $table->enum('state', array('pending', 'payed'));
            $table->string('emitter_name');
            $table->string('emitter_surname');
            $table->string('emitter_commercial_name');
            $table->string('emitter_telephone1');
            $table->string('emitter_telephone2');
            $table->string('emitter_fax');
            $table->string('emitter_email');
            $table->string('emitter_business_id');
            $table->string('emitter_street1');
            $table->string('emitter_street2');
            $table->string('emitter_city');
            $table->string('emitter_state');
            $table->string('emitter_zip');
            $table->string('emitter_country');
            $table->string('recipient_name');
            $table->string('recipient_surname');
            $table->string('recipient_commercial_name');
            $table->string('recipient_telephone1');
            $table->string('recipient_telephone2');
            $table->string('recipient_fax');
            $table->string('recipient_email');
            $table->string('recipient_business_id');
            $table->string('recipient_street1');
            $table->string('recipient_street2');
            $table->string('recipient_city');
            $table->string('recipient_state');
            $table->string('recipient_zip');
            $table->string('recipient_country');
            $table->integer('user_id');
            $table->integer('project_id');
            $table->integer('series_id');
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
		Schema::drop('invoices');
	}

}
