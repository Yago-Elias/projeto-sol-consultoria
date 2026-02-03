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
        Schema::table('tasks', function (Blueprint $table) {
            $table->enum('status', ['PENDENTE', 'EM_APROVACAO', 'APROVADA'])->default('PENDENTE')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->enum('status', ['PENDENTE', 'APROVADA', 'EM_APROVACAO', 'ATRASADA', 'FINALIZADA_COM_ATRASO'])->default('pendente')->change();
        });
    }
};
