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
        Schema::create('bank_soal_events', function (Blueprint $table) {
            $table->id();
            $table->string('kodeEvent');
            $table->string('idSoalUtama');
            $table->string('creator');
            $table->string('judul');
            $table->string('prePost');
            $table->boolean('soalUmum');
            $table->boolean('nilai');
            $table->boolean('bahas');
            $table->boolean('acakMc');
            $table->boolean('acakTf');
            $table->boolean('acakMatch');
            $table->boolean('bobotBalanced');
            $table->integer('bobotMc');
            $table->integer('bobotTf');
            $table->integer('bobotMatch');
            $table->integer('batasiMc');
            $table->integer('batasiTf');
            $table->string('remark');
            $table->datetime('validUntil');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_soal_events');
    }
};
