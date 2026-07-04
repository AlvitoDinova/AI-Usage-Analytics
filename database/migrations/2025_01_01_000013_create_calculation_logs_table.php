<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calculation_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assessment_id');
            $table->enum('tahap', [
                'Matriks Keputusan',
                'Normalisasi',
                'Matriks Terbobot',
                'Solusi Ideal Positif',
                'Solusi Ideal Negatif',
                'Jarak Positif',
                'Jarak Negatif',
                'Nilai Preferensi',
                'Ranking'
            ]);
            $table->longText('data_json'); // Stores calculation matrix/data of that step
            $table->timestamp('created_at')->useCurrent();

            $table->index('assessment_id');
            $table->index('tahap');

            $table->foreign('assessment_id')
                  ->references('id')->on('assessments')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calculation_logs');
    }
};
