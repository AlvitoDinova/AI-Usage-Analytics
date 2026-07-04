<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matrix_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ai_id');
            $table->unsignedBigInteger('criteria_id');
            $table->tinyInteger('nilai')->default(3);

            $table->unique(['ai_id', 'criteria_id']);
            $table->index('criteria_id');

            $table->foreign('ai_id')
                  ->references('id')->on('ai_tools')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('criteria_id')
                  ->references('id')->on('criteria')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matrix_values');
    }
};
