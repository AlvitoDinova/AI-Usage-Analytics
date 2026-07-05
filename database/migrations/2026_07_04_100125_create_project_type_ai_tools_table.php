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
        Schema::create('project_type_ai_tools', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_type_id');
            $table->unsignedBigInteger('ai_tool_id');
            $table->timestamps();

            $table->foreign('project_type_id')
                  ->references('id')->on('project_types')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('ai_tool_id')
                  ->references('id')->on('ai_tools')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->unique(['project_type_id', 'ai_tool_id'], 'uq_project_type_ai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_type_ai_tools');
    }
};
