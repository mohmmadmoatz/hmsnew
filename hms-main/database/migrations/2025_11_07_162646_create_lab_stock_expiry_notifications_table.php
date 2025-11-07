<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabStockExpiryNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_stock_expiry_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_item_id');
            $table->enum('notification_type', ['expiring_soon', 'expired', 'critical_expiry']);
            $table->integer('days_until_expiry');
            $table->date('expiry_date');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->unsignedBigInteger('notified_user_id');
            $table->timestamps();

            $table->index(['stock_item_id', 'notification_type'], 'lab_stock_expiry_item_type_idx');
            $table->index(['notified_user_id', 'is_read'], 'lab_stock_expiry_user_read_idx');
            $table->index('expiry_date', 'lab_stock_expiry_date_idx');

            $table->foreign('stock_item_id')->references('id')->on('lab_stock_items')->onDelete('cascade');
            $table->foreign('notified_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lab_stock_expiry_notifications');
    }
}
