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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('warehouse');
            $table->integer('employee_id');
            $table->string('email');
            $table->string('phone');
            $table->string('phone_work')->nullable();
            $table->text('address');
            $table->integer('city');
            $table->integer('state');
            $table->integer('country');
            $table->string('postal_code');
            $table->boolean('status')->default(1)->comment('1=active, 0=deactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
