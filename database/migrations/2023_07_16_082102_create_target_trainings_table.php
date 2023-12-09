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
        Schema::create('target_trainings', function (Blueprint $table) {
            $table->id();
            $table->string('nrp');
            $table->string('kodeTr');
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->foreignId('instructor')->nullable();
            $table->foreignId('lembaga');
            $table->foreignId('lokasi');
            $table->string('jenisTraining');
            $table->integer('tahun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_trainings');
    }
};
