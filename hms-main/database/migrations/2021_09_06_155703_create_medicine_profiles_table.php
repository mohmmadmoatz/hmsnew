<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicineProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicine_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id')->nullable();
            $table->string('room_id')->nullable();
            $table->string('doctor_id')->nullable();
            $table->string('opration_id')->nullable();
            $table->string('inter_at')->nullable();
            $table->string('identity_circule')->nullable();
            $table->string('identity_page')->nullable();
            $table->string('identity_book')->nullable();
            $table->string('relaitve_name')->nullable();
            $table->string('relaitve_phone')->nullable();
            $table->string('job')->nullable();
            $table->string('mother')->nullable();
            $table->string('Nationality')->nullable();
            $table->string('adress')->nullable();

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
        Schema::dropIfExists('medicine_profiles');
    }
}
