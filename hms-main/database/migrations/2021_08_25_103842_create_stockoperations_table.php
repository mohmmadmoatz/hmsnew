<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockoperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockoperations', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->nullable();
            $table->string('op_type')->nullable();
            $table->string('to_person')->nullable();
            $table->string('to_department')->nullable();
            $table->text('notes')->nullable();
            $table->text('qty')->nullable();
            $table->text('price')->nullable();

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
        Schema::dropIfExists('stockoperations');
    }
}
