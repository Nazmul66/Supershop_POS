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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->text('image');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('contact_number');
            $table->string('employee_code');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('nationality');
            $table->string('religion');
            $table->string('joining_date');
            $table->string('shift');
            $table->integer('department_id');
            $table->integer('designation_id');
            $table->string('blood_group');
            $table->text('about')->nullable();
            $table->string('address');
            $table->integer('country_id');
            $table->integer('city_id');
            $table->integer('state_id');
            $table->string('zip_code');
            $table->string('emergency_number_1');
            $table->string('emergency_number_2')->nullable();
            $table->string('emergency_relation_1');
            $table->string('emergency_relation_2')->nullable();
            $table->string('relation_name_1');
            $table->string('relation_name_2')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('routing_number')->nullable();
            $table->string('branch_name')->nullable();
            $table->boolean('status')->default(1)->comment('1=active, 0=Deactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
