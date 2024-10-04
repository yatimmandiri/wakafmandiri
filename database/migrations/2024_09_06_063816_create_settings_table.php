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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('handphone');
            $table->string('email');
            $table->string('logo')->default('logo.png');
            $table->string('logoWhite')->default('logoWhite.png');
            $table->string('favicon')->default('favicon.png');
            $table->string('sertifikat')->default('sertifikat.png');
            $table->string('facebook')->default('#');
            $table->string('twitter')->default('#');
            $table->string('instagram')->default('#');
            $table->string('youtube')->default('#');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
