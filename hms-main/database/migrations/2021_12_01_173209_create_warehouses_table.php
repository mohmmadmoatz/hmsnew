<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
          
            $table->id();
            $table->string('supplier_name', 255)->nullable();
            $table->date('date');
            $table->string('menu_no', 255)->nullable();
            $table->longText('address')->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('currency', 255)->nullable();
            
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
        Schema::dropIfExists('warehouses');
    }
}
