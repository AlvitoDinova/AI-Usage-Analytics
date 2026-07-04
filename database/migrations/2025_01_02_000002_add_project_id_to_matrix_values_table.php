<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First truncate to avoid any constraint issues
        DB::table('matrix_values')->truncate();

        Schema::table('matrix_values', function (Blueprint $table) {
            // 1. Drop foreign keys that rely on the unique index
            $table->dropForeign('matrix_values_ai_id_foreign');
            $table->dropForeign('matrix_values_criteria_id_foreign');
            
            // 2. Drop unique index
            $table->dropUnique('matrix_values_ai_id_criteria_id_unique');
            
            // 3. Add project_id column
            $table->unsignedBigInteger('project_id')->after('id');
            
            // 4. Re-add foreign keys
            $table->foreign('ai_id')
                  ->references('id')->on('ai_tools')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('criteria_id')
                  ->references('id')->on('criteria')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('project_id')
                  ->references('id')->on('projects')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
                  
            // 5. Add new unique index
            $table->unique(['project_id', 'ai_id', 'criteria_id'], 'uq_project_ai_criteria');
        });
    }

    public function down(): void
    {
        Schema::table('matrix_values', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropForeign(['ai_id']);
            $table->dropForeign(['criteria_id']);
            $table->dropUnique('uq_project_ai_criteria');
            $table->dropColumn('project_id');
            
            $table->foreign('ai_id')
                  ->references('id')->on('ai_tools')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('criteria_id')
                  ->references('id')->on('criteria')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
                  
            $table->unique(['ai_id', 'criteria_id'], 'matrix_values_ai_id_criteria_id_unique');
        });
    }
};
