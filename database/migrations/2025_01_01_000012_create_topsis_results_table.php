<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topsis_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assessment_id');
            $table->unsignedBigInteger('ai_id');
            $table->decimal('nilai_preferensi', 10, 8); // Ci* (0 - 1)
            $table->integer('ranking');
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['assessment_id', 'ai_id']);
            $table->index('ai_id');
            $table->index('ranking');

            $table->foreign('assessment_id')
                  ->references('id')->on('assessments')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('ai_id')
                  ->references('id')->on('ai_tools')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topsis_results');
    }
};
