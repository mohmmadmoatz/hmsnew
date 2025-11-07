<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatTestComponetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pat_test_componets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pat_test_id')->nullable();
            $table->bigInteger('test_id')->nullable();
            $table->bigInteger('componet_id')->nullable();
            $table->string('result', 255)->nullable();
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
        Schema::dropIfExists('pat_test_componets');
    }
}
