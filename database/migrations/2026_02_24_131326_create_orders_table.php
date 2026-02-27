<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number');
            $table->string('order_id');
            $table->string('invoice_id');
            $table->integer('subtotal');
            $table->integer('total_amount');
            $table->string('currency_name');
            $table->string('currency_symbol');
            $table->string('product_qty');
            $table->string('payment_method');
            $table->string('payment_status');
            $table->integer('delivery_charge');
            $table->text('coupon')->nullable();
            $table->text('order_address');
            $table->string('order_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
