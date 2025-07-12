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
        Schema::create('cms_attachment', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->nullable();
            $table->bigInteger('group_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->unsignedBigInteger('huongdanvien_id')->nullable();
            $table->longText('ten')->nullable();
            $table->longText('url')->nullable();
            $table->string('mime', 75)->nullable();
            $table->bigInteger('size')->nullable();
            $table->integer('type')->nullable();
            $table->bigInteger('object_id')->nullable();
            $table->bigInteger('folder_id')->nullable();
            $table->longText('ghichu')->nullable();
            $table->integer('trangthai')->nullable();
            $table->bigInteger('nguoitao')->nullable();
            $table->bigInteger('nguoicapnhat')->nullable();
            $table->dateTime('ngaytao', 6)->nullable();
            $table->dateTime('ngaycapnhat', 6)->nullable();
            $table->integer('daxoa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_attachment');
    }
};
