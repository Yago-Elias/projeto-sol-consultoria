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
            $table->foreignId('type')->constrained('financial_types');
            $table->foreignId('nature')->constrained('financial_natures');
            $table->foreignId('provider')->constrained('providers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financial_entries', function (Blueprint $table) {
            $table->dropForeign(['type']);
            $table->dropForeign(['nature']);
            $table->dropForeign(['provider']);    
        });
    }
};
