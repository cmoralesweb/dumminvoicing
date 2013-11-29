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
            $table->decimal('quantity', 25, 4);
            $table->decimal('unit_price', 25, 2);
            $table->decimal('tax_amount', 25, 2);
            $table->decimal('gross_total', 25, 2);
            $table->decimal('total', 25, 2);
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
