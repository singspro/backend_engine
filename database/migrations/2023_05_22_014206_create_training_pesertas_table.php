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
        Schema::create('training_pesertas', function (Blueprint $table) {
            $table->id();
            $table->string('idTr');
            $table->string('nrp');
            $table->decimal('pre')->nullable();
            $table->decimal('post')->nullable();
            $table->decimal('practice')->nullable();
            $table->string('result')->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_pesertas');
    }
};
