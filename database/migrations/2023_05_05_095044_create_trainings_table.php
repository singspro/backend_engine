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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('idTr')->unique();
            $table->string('kodeTr');
            $table->foreignId('uraianMateri');
            $table->foreignId('lokasi');
            $table->foreignId('lembaga');
            $table->foreignId('instructor');
            $table->string('category');
            $table->string('programTraining');
            $table->string('hardSoft');
            $table->date('start');
            $table->date('end');
            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
