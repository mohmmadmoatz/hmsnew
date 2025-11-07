<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseExportItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_export_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id');
            $table->float('qty')->nullable()->default(1);
            $table->double('amount', 20, 8)->nullable()->default(0);
            $table->double('total', 20, 8)->nullable()->default(0);
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
        Schema::dropIfExists('warehouse_export_items');
    }
}
