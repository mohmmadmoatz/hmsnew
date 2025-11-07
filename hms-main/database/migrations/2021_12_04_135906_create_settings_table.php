<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            
            $table->double('xray', 20, 8)->nullable()->default(0.0);
            $table->double('sonar', 20, 8)->nullable()->default(0.0);
            $table->double('clinic_price', 20, 8)->nullable()->default(0.0);
            $table->double('doctor_price', 20, 8)->nullable()->default(0.0);
            $table->bigInteger('doctor_id');
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
        Schema::dropIfExists('settings');
    }
}
