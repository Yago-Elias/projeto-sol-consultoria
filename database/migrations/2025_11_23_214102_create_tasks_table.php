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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('predicted_hours');
            $table->date('due_date');
            $table->date('conclusion_date')->nullable();
            $table->text('conclusion_message')->nullable();

            $table->enum('status', ['PENDENTE', 'APROVADA', 'EM_APROVACAO', 'ATRASADA', 'FINALIZADA_COM_ATRASO'])->default('pendente');

            $table->foreignId('board_id')->constrained('board');
            $table->foreignId('assigned_to')->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
