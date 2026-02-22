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
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('permissions');

            $table->unsignedSmallInteger('manage_projects');
            $table->unsignedSmallInteger('manage_users');

            $table->unsignedSmallInteger('task_access');
            $table->unsignedSmallInteger('financial_access');

            $table->boolean('system_config');
            $table->boolean('global_access');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->unsignedSmallInteger('permissions');
            $table->dropColumn(['system_config', 'users_permission', 'projects_permission']);
        });
    }
};
