<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('client', 150)->after('nama_proyek');
            $table->enum('status', ['Draft', 'Dinilai', 'Selesai'])->default('Draft')->after('deskripsi');
            $table->date('tanggal')->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['client', 'status', 'tanggal']);
        });
    }
};
