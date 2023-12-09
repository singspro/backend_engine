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
        Schema::create('oji_reports', function (Blueprint $table) {
            $table->id();
            $table->string('idOji');
            $table->string('nrp');
            $table->string('kodeKompetensi');
            $table->date('startDate');
            $table->date('endDate');
            $table->time('startTime');
            $table->time('endTime');
            $table->foreignId('instructor');
            $table->string('jenisOji');
            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oji_reports');
    }
};
