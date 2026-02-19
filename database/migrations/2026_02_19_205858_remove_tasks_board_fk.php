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
            $table->dropForeign(['board_id']);
            $table->dropColumn(['board_id']);

            $table->enum('status', ['PENDENTE', 'EM_PROGRESSO', 'EM_APROVACAO', 'APROVADA'])->default('PENDENTE')->change();

            $table->foreignId('project_id')->constrained('projects');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('board_id')->constrained('boards');

            $table->enum('status', ['PENDENTE', 'EM_PROGRESSO', 'EM_APROVACAO', 'APROVADA'])->default('PENDENTE')->change();

            $table->dropForeign(['project_id' ]);
            $table->dropColumn(['project_id']);
        });
    }
};
