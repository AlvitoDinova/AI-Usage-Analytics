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
        Schema::create('project_ai_tools', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('ai_tool_id');
            $table->timestamps();

            $table->foreign('project_id')
                  ->references('id')->on('projects')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('ai_tool_id')
                  ->references('id')->on('ai_tools')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->unique(['project_id', 'ai_tool_id'], 'uq_project_ai_tool');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_ai_tools');
    }
};
