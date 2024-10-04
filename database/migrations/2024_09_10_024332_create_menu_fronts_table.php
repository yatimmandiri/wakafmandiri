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
        Schema::create('menu_fronts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->default('fas fa-chevron-right nav-icons');
            $table->string('link')->default('#');
            $table->string('parent');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_fronts');
    }
};
