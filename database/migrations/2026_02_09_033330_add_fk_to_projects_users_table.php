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
        Schema::table('projects_users', function (Blueprint $table) {
            $table->foreignId('attribution_id')->nullable()->constrained('project_attributions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects_users', function (Blueprint $table) {
            $table->dropForeign('attribution_id');
            $table->dropColumn('attribution_id');
        });
    }
};
