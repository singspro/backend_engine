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
        Schema::create('bank_soal_hasil_pesertas', function (Blueprint $table) {
            $table->id();
            $table->string('kodeEvent');
            $table->longText('tokenPeserta');
            $table->bigInteger('idMp')->nullable();
            $table->string('nama');
            $table->string('perusahaan');
            $table->string('jabatanFn');
            $table->integer('benar')->nullable();
            $table->integer('salah')->nullable();
            $table->decimal('nilai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_soal_hasil_pesertas');
    }
};
