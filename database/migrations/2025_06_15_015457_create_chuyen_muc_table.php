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
        Schema::create('chuyen_muc', function (Blueprint $table) {
            $table->id();
            $table->string('ten', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->integer('trangthai')->default(0); // Trạng thái: 1 - Hiện, 0 - Ẩn
            $table->integer('daxoa')->default(0); // 1 - Đã xóa, 0 - Chưa xóa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chuyen_muc');
    }
};
