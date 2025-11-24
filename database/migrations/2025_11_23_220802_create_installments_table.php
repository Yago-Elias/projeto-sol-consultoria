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
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('number');
            $table->float('value');
            $table->date('due_date');
            $table->date('payment_date')->nullable();

            $table->enum('status', ['ABERTA', 'PAGA', 'ATRASADA', 'PAGA_COM_ATRASO'])->default('ABERTA');

            $table->timestamps();

            $table->foreignId('financial_entry_id')->constrained('financial_entries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
