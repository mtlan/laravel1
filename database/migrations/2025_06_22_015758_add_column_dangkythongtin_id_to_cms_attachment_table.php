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
        Schema::table('cms_attachment', function (Blueprint $table) {
            $table->unsignedBigInteger('dangkythongtin_id')->nullable();
            $table->foreign('dangkythongtin_id')->references('id')->on('hdvdl_dangkythongtin')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_attachment', function (Blueprint $table) {
            //
        });
    }
};
