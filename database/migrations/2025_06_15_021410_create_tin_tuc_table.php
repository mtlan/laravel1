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
        Schema::create('tin_tuc', function (Blueprint $table) {
            $table->id();
            $table->string('ten', 255)->nullable(); // Tiêu đề tin tức
            $table->string('slug', 255)->nullable(); // Slug tin tức
            $table->string('hinhanh', 500)->nullable(); // Hình ảnh tin tức
            $table->text('mota')->nullable(); // Mô tả tin tức
            $table->longText('noidung')->nullable(); // Nội dung tin tức
            $table->string('filedinhkem')->nullable(); // Nội dung tin tức
            $table->string('tukhoa', 255)->nullable(); // Từ khóa tin tức
            $table->integer('luotxem')->nullable(); 
            $table->smallInteger('noibat')->default(0); // Nổi bật (0: Không, 1: Có)
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
        Schema::dropIfExists('tin_tuc');
    }
};
