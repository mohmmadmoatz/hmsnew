<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();
            $table->string('bp', 255)->nullable();
            $table->string('pr', 255)->nullable();
            $table->string('drain', 255)->nullable();
            $table->string('itake', 255)->nullable();
            $table->string('spo2', 255)->nullable();
            $table->string('Temp', 255)->nullable();
            $table->bigInteger('user_id');
            $table->bigInteger('pat_id')->nullable();
            $table->string('treatment', 255)->nullable();
            $table->string('date', 255)->nullable();
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
        Schema::dropIfExists('follow_ups');
    }
}
