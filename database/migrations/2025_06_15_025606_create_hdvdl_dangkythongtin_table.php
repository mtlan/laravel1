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
        Schema::create('hdvdl_dangkythongtin', function (Blueprint $table) {
            $table->id();
            $table->string('ho_tenlot', 400)->nullable(); // Họ và tên lót
            $table->string('ten', 400)->nullable(); // Tên
            $table->dateTime('ngaysinh')->nullable(); // Ngày sinh
            $table->integer('gioitinh')->nullable(); // Giới tính
            $table->string('sdt1', 75)->nullable(); // Số điện thoại 1
            $table->string('email1', 75)->nullable(); // Email 1
            $table->string('cmnd_so', 75)->nullable(); // Số CMND
            $table->dateTime('cmnd_ngaycap')->nullable(); // Ngày cấp CMND
            $table->string('cmnd_noicap', 75)->nullable(); // Nơi cấp CMND
            $table->text('diachi')->nullable(); // Địa chỉ
            $table->string('trangthai')->nullable(); // Trạng thái
            $table->unsignedBigInteger('huongdan_tiengchinh')->nullable(); // ID hướng dẫn tiếng chính
            $table->string('sothe', 500)->nullable(); // Số thẻ
            $table->unsignedBigInteger('noicapthe_id')->nullable(); // Nơi cấp thẻ
            $table->unsignedBigInteger('thoihanthe_id')->nullable(); // Thời hạn thẻ
            $table->dateTime('tungay')->nullable(); // Từ ngày
            $table->dateTime('denngay')->nullable(); // Đến ngày
            $table->integer('daxoa')->nullable(); // Đã xóa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hdvdl_dangkythongtin');
    }
};
