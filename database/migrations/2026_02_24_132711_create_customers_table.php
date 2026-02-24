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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('cus_id');
            $table->string('cus_type');
            $table->string('cus_name');
            $table->string('cus_phone');
            $table->string('cus_email')->nullable();
            $table->string('cus_tag');
            $table->string('cus_source');
            $table->string('cus_address');
            $table->string('additional_note')->nullable();
            $table->string('internal_note')->nullable();
            $table->string('save_as')->comment("home,work,other");
            $table->integer('status')->default(1)->comment("1=Active, 0=Deactive");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
