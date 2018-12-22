<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUserBalanceTransactionTable
 */
class CreateUserBalanceTransactionTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up () {
		Schema::create('UserBalanceTransaction', function (Blueprint $table) {
			$table->increments('id');
			$table->dateTime('date');
			$table->integer('user');
			$table->double('amount');
			$table->string('status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down () {
		Schema::dropIfExists('User');
	}
}