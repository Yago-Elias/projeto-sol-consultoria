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
        Schema::table('financial_entries', function (Blueprint $table) {
            $table->dropForeign(['provider']);
            $table->foreignId('provider')->nullable()->change();
            $table->foreign('provider')->references('id')->on('providers')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financial_entries', function (Blueprint $table) {
            $table->dropForeign(['provider']);
            $table->foreignId('provider')->constrained('providers')->change();
        });
    }
};
