<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppliedTaxesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('applied_taxes', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name');
            $table->decimal('percentage', 20, 10)->default(0);
            $table->integer('item_id');
            $table->tinyInteger('priority')->default(0);
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
		Schema::drop('applied_taxes');
	}

}
