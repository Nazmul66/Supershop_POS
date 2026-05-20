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
        Schema::create('product_branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->integer('qty')->default(0);
            $table->integer('alert_qty')->default(0);
            $table->integer('purchase_price')->default(0);
            $table->integer('selling_price')->default(0);
            $table->integer('profit_margin')->default(0);
            $table->enum('discount_type', ['fixed', 'percent'])->nullable();
            $table->integer('discount_value')->nullable();
            $table->date('discount_start')->nullable();
            $table->date('discount_end')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_branches');
    }
};
