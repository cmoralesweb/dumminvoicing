<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('items', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('invoice_id');
            $table->string('product_name');
            $table->decimal('quantity', 25, 4)->default(0);
            $table->decimal('unit_price', 25, 4)->default(0)->unsigned();
            $table->decimal('tax_amount', 25, 4)->default(0);
            $table->decimal('gross_total', 25, 4)->default(0);
            $table->decimal('total', 25, 4)->default(0);
            $table->decimal('discount', 25, 4)->nullable();
            $table->enum('discount_type', array('percent', 'fixed'))->nullable();
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
		Schema::drop('items');
	}

}
