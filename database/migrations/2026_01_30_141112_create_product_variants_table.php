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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('variant_id');
            $table->string('variant_name');
            $table->string('variant_code');  // as we call SKU Code
            $table->integer('qty');
            $table->integer('alert_qty');
            $table->integer('purchase_price');
            $table->integer('profit_margin');
            $table->integer('selling_price');
            $table->integer('variant_dis_type')->nullable();
            $table->integer('variant_dis_value')->nullable();
            $table->integer('variant_dis_date')->nullable();
            $table->boolean('status')->default(1)->comment('1=active, 0=Deactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
