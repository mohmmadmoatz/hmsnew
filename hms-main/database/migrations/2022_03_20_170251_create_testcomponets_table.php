<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestcomponetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testcomponets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string('result_type', 255)->nullable();
            $table->longText('options')->nullable();
            $table->string('unit', 255)->nullable();
            $table->string('normal_range', 255)->nullable();
            
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
        Schema::dropIfExists('testcomponets');
    }
}
