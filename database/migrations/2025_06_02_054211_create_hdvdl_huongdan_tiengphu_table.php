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
        Schema::create('hdvdl_huongdan_tiengphu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('huongdanvien_id')->nullable(); // ID hướng dẫn viên
            $table->unsignedBigInteger('ngonngu_id')->nullable(); // ID ngôn ngữ
            $table->integer('trangthai')->nullable(); // Trạng thái
            $table->integer('daxoa')->nullable(); // Đã xóa

            // Định nghĩa khóa ngoại
            $table->foreign('huongdanvien_id')->references('id')->on('hdvdl_huongdanvien')->onDelete('cascade');
            $table->foreign('ngonngu_id')->references('id')->on('hdvdl_dm_ngonngu')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hdvdl_huongdan_tiengphu');
    }
};
