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
        Schema::create('sub_folders', function (Blueprint $table) {
            $table->id();
            $table->string('ten')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('parent_id');
            $table->integer('trangthai')->default(0); // Trạng thái: 1 - Hiện, 0 - Ẩn
            $table->integer('daxoa')->default(0); // 1 - Đã xóa, 0 - Chưa xóa
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('parent_directories')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_folders');
    }
};
