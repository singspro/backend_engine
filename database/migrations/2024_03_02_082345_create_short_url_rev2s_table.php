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
        Schema::create('short_url_rev2s', function (Blueprint $table) {
            $table->id();
            $table->longText('urlShroten');
            $table->longText('slug');
            $table->longText('urlTarget');
            $table->text('creator');
            $table->longText('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('short_url_rev2s');
    }
};
