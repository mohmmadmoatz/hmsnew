<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFdebitTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fdebit_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('number');
            $table->string('name');
            $table->double('amount_iqd', 24, 8)->nullable();
            $table->double('amount_usd', 24, 8)->nullable();    
            $table->string('exchange_rate', 255)->nullable();
            $table->string('notes')->nullable();
            $table->date('date');
            
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
        Schema::dropIfExists('fdebit_transactions');
    }
}
