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
        Schema::create('bank_soal_hasil_jawaban_models', function (Blueprint $table) {
            $table->id();
            $table->string('kodeEvent');
            $table->longText('tokenPeserta');
            $table->integer('revisiSoal');
            $table->string('idSoalUtama');
            $table->string('idSoalIsi');
            $table->integer('jenis');
            $table->integer('idSoalMatch')->nullable();
            $table->string('jawaban')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_soal_hasil_jawaban_models');
    }
};
