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
            $table->string('emitter_name')->nullable();
            $table->string('emitter_surname')->nullable();
            $table->string('emitter_commercial_name')->nullable();
            $table->string('emitter_telephone1')->nullable();
            $table->string('emitter_telephone2')->nullable();
            $table->string('emitter_fax')->nullable();
            $table->string('emitter_email')->nullable();
            $table->string('emitter_business_id')->nullable();
            $table->string('emitter_street1')->nullable();
            $table->string('emitter_street2')->nullable();
            $table->string('emitter_city')->nullable();
            $table->string('emitter_state')->nullable();
            $table->string('emitter_zip')->nullable();
            $table->string('emitter_country')->nullable();
            $table->string('recipient_name')->nullable();
            $table->string('recipient_surname')->nullable();
            $table->string('recipient_commercial_name')->nullable();
            $table->string('recipient_telephone1')->nullable();
            $table->string('recipient_telephone2')->nullable();
            $table->string('recipient_fax')->nullable();
            $table->string('recipient_email')->nullable();
            $table->string('recipient_business_id')->nullable();
            $table->string('recipient_street1')->nullable();
            $table->string('recipient_street2')->nullable();
            $table->string('recipient_city')->nullable();
            $table->string('recipient_state')->nullable();
            $table->string('recipient_zip')->nullable();
            $table->string('recipient_country')->nullable();
            $table->boolean('sent');
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
