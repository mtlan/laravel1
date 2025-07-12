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
        Schema::create('hdvdl_huongdanvien', function (Blueprint $table) {
            $table->id();
            $table->string('ho_tenlot', 400)->nullable(); // Họ và tên lót
            $table->string('ten', 400)->nullable(); // Tên
            $table->string('tendaydu', 500)->nullable(); // Tên đầy đủ
            $table->dateTime('ngaysinh')->nullable(); // Ngày sinh
            $table->integer('gioitinh')->nullable(); // Giới tính
            $table->string('sdt1', 75)->nullable(); // Số điện thoại 1
            $table->string('sdt2', 75)->nullable(); // Số điện thoại 2
            $table->string('email1', 75)->nullable(); // Email 1
            $table->string('email2', 75)->nullable(); // Email 2
            $table->string('cmnd_so', 75)->nullable(); // Số CMND
            $table->dateTime('cmnd_ngaycap')->nullable(); // Ngày cấp CMND
            $table->string('cmnd_noicap', 75)->nullable(); // Nơi cấp CMND
            $table->text('diachi')->nullable(); // Địa chỉ
            $table->longText('anhtheBase64')->nullable(); // Ảnh thẻ Base64
            $table->dateTime('ngaytao')->nullable(); // Ngày tạo
            $table->unsignedBigInteger('nguoitao')->nullable(); // Người tạo (khóa ngoại)
            $table->dateTime('ngaysua')->nullable(); // Ngày sửa
            $table->unsignedBigInteger('nguoisua')->nullable(); // Người sửa (khóa ngoại)
            $table->integer('trangthai')->nullable(); // Trạng thái
            $table->integer('daxoa')->nullable(); // Đã xóa

            // Định nghĩa khóa ngoại
            $table->foreign('nguoitao')->references('id')->on('users')->onDelete('set null');
            $table->foreign('nguoisua')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hdvdl_huongdanvien');
    }
};
