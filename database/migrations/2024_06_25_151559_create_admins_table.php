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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("type")->nullable();
            $table->string("phone");
            $table->string("email")->unique();
            $table->string("password");
            $table->string("image")->nullable();
            $table->tinyInteger("status")->default(1)->nullable();
            $table->string("two_factor_code")->nullable();
            $table->dateTime("two_factor_expire_at")->nullable();
            $table->foreignId('current_branch_id')->nullable()->after('id');
            $table->foreignId('current_device_id')->nullable()->after('current_branch_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
