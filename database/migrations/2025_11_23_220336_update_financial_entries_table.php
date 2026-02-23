<?php

use App\Models\FinancialType;
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
            $table->foreignId('type')->nullable()->constrained('financial_types')->nullOnDelete();
            $table->foreignId('nature')->nullable()->constrained('financial_natures')->nullOnDelete();
            $table->foreignId('provider')->nullable()->constrained('providers')->nullOnDelete();

            $table->softDeletes();
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
