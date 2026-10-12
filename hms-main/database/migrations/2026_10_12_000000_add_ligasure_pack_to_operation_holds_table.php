<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLigasurePackToOperationHoldsTable extends Migration
{
    public function up()
    {
        Schema::table('operation_holds', function (Blueprint $table) {
            if (!Schema::hasColumn('operation_holds', 'ligasure_count')) {
                $table->unsignedInteger('ligasure_count')->nullable()->default(0);
            }
            if (!Schema::hasColumn('operation_holds', 'pack_count')) {
                $table->unsignedInteger('pack_count')->nullable()->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('operation_holds', function (Blueprint $table) {
            $table->dropColumn(['ligasure_count', 'pack_count']);
        });
    }
}
