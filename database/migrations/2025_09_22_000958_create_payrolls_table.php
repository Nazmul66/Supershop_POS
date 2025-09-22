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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->integer('basic_salary');
            $table->integer('hra_allow');
            $table->integer('conveyance');
            $table->integer('medical_allow');
            $table->integer('bonus');
            $table->integer('provident_fund');
            $table->integer('professional_tax');
            $table->integer('tds');
            $table->integer('loan_others');
            $table->boolean('status')->default(1)->comment('1=Paid, 0=Unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
