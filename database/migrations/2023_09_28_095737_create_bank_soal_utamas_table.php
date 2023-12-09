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
        Schema::create('bank_soal_utamas', function (Blueprint $table) {
            $table->id();
            $table->string('idSoalUtama')->unique();
            $table->string('judul');
            $table->string('author');
            $table->string('revisi');
            $table->decimal('tingkatKesulitan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_soal_utamas');
    }
};
