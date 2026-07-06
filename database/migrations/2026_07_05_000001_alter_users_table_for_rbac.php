<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key and column role_id
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');

            // Rename column nama to name
            $table->renameColumn('nama', 'name');

            // Add role and status columns
            $table->enum('role', ['admin', 'manager', 'employee'])->default('employee')->after('password');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status']);
            $table->renameColumn('name', 'nama');
            $table->unsignedBigInteger('role_id')->default(2);
            $table->foreign('role_id')
                  ->references('id')->on('roles')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }
};
