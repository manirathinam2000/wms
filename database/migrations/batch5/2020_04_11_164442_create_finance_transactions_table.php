<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('company_id')->nullable();
			$table->unsignedBigInteger('account_id')->nullable();
			$table->string('amount',30);
			$table->string('category',30);
			$table->unsignedBigInteger('category_id')->nullable();
			$table->mediumText('description')->nullable();
			$table->unsignedBigInteger('payment_method_id')->nullable();
			$table->unsignedBigInteger('payee_id')->nullable();
			$table->unsignedBigInteger('payer_id')->nullable();
			$table->string('expense_reference')->nullable();
			$table->string('expense_file')->nullable();
			$table->date('expense_date')->nullable();
			$table->string('deposit_reference')->nullable();
			$table->string('deposit_file')->nullable();
			$table->date('deposit_date')->nullable();

			$table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
			$table->foreign('account_id')->references('id')->on('finance_bank_cashes')->onDelete('set null');
			$table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('set null');
			$table->foreign('payee_id')->references('id')->on('finance_payees')->onDelete('set null');
			$table->foreign('payer_id')->references('id')->on('finance_payers')->onDelete('set null');
			$table->foreign('category_id')->references('id')->on('expense_types')->onDelete('set null');

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
        Schema::dropIfExists('finance_transactions');
    }
}
