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
        Schema::create('taf_data', function (Blueprint $table) {
            $table->id();
            $table->string('idTaf');
            $table->string('kodeTraining');
            $table->foreignId('kodeUraianMateri');
            $table->foreignId('lembaga');
            $table->date('startDate');
            $table->date('endDate');
            $table->foreignId('lokasi');
            $table->integer('biaya')->nullable();
            $table->string('pjo')->nullable();
            $table->string('divisi')->nullable();
            $table->string('dept')->nullable();
            $table->string('hr')->nullable();
            $table->string('createDate');
            $table->string('to');
            $table->string('from');
            $table->string('subject');
            $table->string('jenisTaf');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taf_data');
    }
};
