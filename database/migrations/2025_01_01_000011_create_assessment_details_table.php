<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assessment_id');
            $table->unsignedBigInteger('criteria_id');
            $table->tinyInteger('bobot')->default(3); // User-selected weight scale 1-5

            $table->unique(['assessment_id', 'criteria_id']);
            $table->index('criteria_id');

            $table->foreign('assessment_id')
                  ->references('id')->on('assessments')
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
        Schema::dropIfExists('assessment_details');
    }
};
