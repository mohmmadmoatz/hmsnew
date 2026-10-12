<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnesthesiaDoctorsToOperationHoldsTable extends Migration
{
    public function up()
    {
        Schema::table('operation_holds', function (Blueprint $table) {
            if (!Schema::hasColumn('operation_holds', 'anesthesia_doctors')) {
                // JSON array of anesthesiologist names (one operation can have more than one)
                $table->text('anesthesia_doctors')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('operation_holds', function (Blueprint $table) {
            $table->dropColumn('anesthesia_doctors');
        });
    }
}
