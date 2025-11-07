<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabStockMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_stock_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_item_id');
            $table->enum('movement_type', ['in', 'out', 'adjustment', 'transfer', 'return', 'waste']);
            $table->integer('quantity');
            $table->integer('previous_quantity');
            $table->integer('current_quantity');
            $table->string('reference_number')->nullable();
            $table->string('reason')->nullable();
            $table->text('notes')->nullable();
            $table->string('performed_by');
            $table->date('movement_date');
            $table->decimal('unit_cost', 10, 2)->nullable();
            $table->decimal('total_cost', 10, 2)->nullable();
            $table->timestamps();

            $table->index(['stock_item_id', 'movement_date']);
            $table->index('movement_type');
            $table->index('movement_date');

            $table->foreign('stock_item_id')->references('id')->on('lab_stock_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lab_stock_movements');
    }
}
