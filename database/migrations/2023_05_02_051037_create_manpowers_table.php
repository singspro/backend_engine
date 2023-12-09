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
        Schema::create('manpowers', function (Blueprint $table) {
            $table->id();
            $table->string('about')->default("-");
            $table->string('nrp')->unique();
            $table->string('noMinePermit')->default("-");
            $table->string('nama');
            $table->foreignId('perusahaan');
            $table->string('jobArea')->default("-");
            $table->string('section')->default("-");
            $table->string('subSection')->default("-");
            $table->string('jabatanStr')->default("-");
            $table->string('jabatanFn')->default("-");
            $table->string('spesialis')->default("-");
            $table->string('grade')->default("-");
            $table->date('jointDate')->default(now());
            $table->string('tempatLahir')->default("-");
            $table->date('tanggalLahir')->nullable();
            $table->string('noTelp1')->default("-");
            $table->string('noTelp2')->default("-");
            $table->string('email')->default("-");
            $table->string('status')->default("AKTIF");
            $table->date('NotActiveStatus')->nullable();
            $table->string('remark')->default("-");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manpowers');
    }
};
