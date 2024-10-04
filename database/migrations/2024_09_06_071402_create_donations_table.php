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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi');
            $table->integer('quantity')->default(1);
            $table->integer('nominal_donasi')->default(0);
            $table->integer('unik_nominal')->default(0);
            $table->text('keterangan')->nullable();
            $table->text('bill_code')->nullable();
            $table->text('va_number')->nullable();
            $table->text('qr_code')->nullable();
            $table->text('deep_links')->nullable();
            $table->json('response_donasi')->nullable();
            $table->enum('status', ['Pending', 'Success', 'Expired'])->default('Pending');
            $table->enum('hamba_allah', ['Y', 'N'])->default('N');
            $table->dateTime('expired')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate('cascade')->cascadeOnDelete('cascade');
            $table->foreignId('campaign_id')->constrained('campaigns')->cascadeOnUpdate('cascade')->cascadeOnDelete('cascade');
            $table->foreignId('rekening_id')->constrained('rekenings')->cascadeOnUpdate('cascade')->cascadeOnDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
