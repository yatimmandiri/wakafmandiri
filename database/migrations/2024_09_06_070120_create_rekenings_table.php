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
        Schema::create('rekenings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number');
            $table->string('bank');
            $table->enum('provider', ['Midtrans', 'Moota'])->default('Midtrans');
            $table->enum('group', ['bank_transfer', 'e_money', 'direct_debit', 'convenience_store', 'cardless_credit'])->default('bank_transfer');
            $table->string('token')->default('-');
            $table->text('icon')->nullable();
            $table->enum('status', ['Y', 'N'])->default('Y');
            $table->enum('recomendation', ['Y', 'N'])->default('N');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekenings');
    }
};
