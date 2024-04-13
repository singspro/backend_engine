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
        Schema::create('manpower_loggers', function (Blueprint $table) {
            $table->id();
            $table->string('perusahaan');
            $table->string('jobArea');
            $table->string('subSection');
            $table->string('jabatan');
            $table->string('grade');
            $table->string('status');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manpower_loggers');
    }
};
