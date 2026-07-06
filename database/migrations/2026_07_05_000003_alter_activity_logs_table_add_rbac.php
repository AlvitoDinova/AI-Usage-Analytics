<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->string('user', 150)->nullable()->after('aktivitas');
            $table->string('role', 50)->nullable()->after('user');
            $table->string('ip_address', 45)->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropColumn(['user', 'role', 'ip_address']);
        });
    }
};
