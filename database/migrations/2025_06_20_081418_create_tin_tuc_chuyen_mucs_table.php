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
        Schema::create('tintuc_chuyenmuc', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tintuc_id');
            $table->unsignedBigInteger('chuyenmuc_id');

            $table->foreign('chuyenmuc_id')->references('id')->on('chuyen_muc')->onDelete('CASCADE');
            $table->foreign('tintuc_id')->references('id')->on('tin_tuc')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tintuc_chuyenmuc');
    }
};
