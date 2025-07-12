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
        Schema::create('hdvdl_the', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('huongdanvien_id')->nullable(); // ID hướng dẫn viên
            $table->unsignedBigInteger('huongdan_tiengchinh')->nullable(); // ID hướng dẫn tiếng chính
            $table->string('sothe', 500)->nullable(); // Số thẻ
            $table->unsignedBigInteger('noicapthe_id')->nullable(); // Nơi cấp thẻ
            $table->unsignedBigInteger('thoihanthe_id')->nullable(); // Thời hạn thẻ
            $table->dateTime('tungay')->nullable(); // Từ ngày
            $table->dateTime('denngay')->nullable(); // Đến ngày
            $table->integer('trangthai')->nullable(); // Trạng thái
            $table->integer('daxoa')->nullable(); // Đã xóa

            // Định nghĩa khóa ngoại
            $table->foreign('huongdanvien_id')->references('id')->on('hdvdl_huongdanvien')->onDelete('cascade');
            $table->foreign('huongdan_tiengchinh')->references('id')->on('hdvdl_dm_ngonngu')->onDelete('cascade');
            $table->foreign('noicapthe_id')->references('id')->on('hdvdl_dm_noicapthe')->onDelete('cascade');
            $table->foreign('thoihanthe_id')->references('id')->on('hdvdl_dm_thoihanthe')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hdvdl_the');
    }
};
