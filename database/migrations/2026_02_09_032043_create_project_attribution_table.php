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
        Schema::create('project_attributions', function (Blueprint $table) {
            $table->id();
            $table->string('attribution');

            $table->unsignedSmallInteger('task_access');
            $table->unsignedSmallInteger('board_access');
            $table->unsignedSmallInteger('financial_access');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_attributions');
    }
};
