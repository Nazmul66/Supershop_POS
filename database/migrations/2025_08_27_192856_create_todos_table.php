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
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('tag')->nullable();
            $table->string('priority')->nullable();
            $table->text('description');
            $table->boolean('important')->default(0)->comment('1=yes, 0=no');
            $table->boolean('todo_cross')->default(0)->comment('1=yes, 0=no');
            $table->integer('assign_user_id');
            $table->integer('priority_status')->default(4)->comment('1=complete, 2=pending,3=onhold,4=inprogress');
            $table->integer('status')->default(1)->comment('1=active, 0=deactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
