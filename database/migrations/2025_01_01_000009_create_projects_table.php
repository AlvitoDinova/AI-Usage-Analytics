<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_type_id');
            $table->string('nama_proyek', 255);
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->index('project_type_id');

            $table->foreign('project_type_id')
                  ->references('id')->on('project_types')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
