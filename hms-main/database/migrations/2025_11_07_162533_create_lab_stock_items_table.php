<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabStockItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_stock_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('category');
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->integer('min_quantity')->default(10);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->string('supplier')->nullable();
            $table->date('purchase_date');
            $table->date('expiry_date');
            $table->string('batch_number')->nullable();
            $table->string('location')->nullable();
            $table->enum('status', ['active', 'expired', 'low_stock', 'out_of_stock'])->default('active');
            $table->boolean('expiry_notification_sent')->default(false);
            $table->integer('days_before_expiry_notification')->default(30);
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->index(['expiry_date', 'status']);
            $table->index('code');
            $table->index('category');

            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lab_stock_items');
    }
}
