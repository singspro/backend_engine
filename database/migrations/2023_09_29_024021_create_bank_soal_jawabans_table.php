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
        Schema::create('bank_soal_jawabans', function (Blueprint $table) {
            $table->id();
            $table->string('idSoalIsi');
            $table->string('pilihanJawaban');
            $table->boolean('jawabanBenar');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_soal_jawabans');
    }
};
