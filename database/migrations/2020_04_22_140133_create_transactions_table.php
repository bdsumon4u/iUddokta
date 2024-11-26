<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reseller_id')->index();
            $table->integer('amount');
            $table->string('method');
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('branch')->nullable();
            $table->string('routing_no')->nullable();
            $table->string('account_type');
            $table->string('account_number');
            $table->string('transaction_number')->nullable();
            $table->string('status')->default('pending')->index();
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
        Schema::dropIfExists('transactions');
    }
}
