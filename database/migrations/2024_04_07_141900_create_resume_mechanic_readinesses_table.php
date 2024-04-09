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
        Schema::create('resume_mechanic_readinesses', function (Blueprint $table) {
            $table->id();
            $table->string('jobArea');
            $table->string('subSection');
            $table->integer('comQtyOpen');
            $table->integer('comQtyClose');
            $table->float('compAch');
            $table->integer('trQtyOpen');
            $table->integer('trQtyClose');
            $table->float('trAch');
            $table->float('readiness');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_mechanic_readinesses');
    }
};
