<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'video';

    protected $fillable = [
        'ten',
        'original_name',
        'url',
        'trangthai',
        'daxoa'
    ];

    public function getTrangThai()
    {
        switch ($this->trangthai) {
            case '1':
                return '<span class="badge bg-success">Đang Hoạt động</span>';
                break;
            case '0':
                return '<span class="badge bg-danger ">Tạm ngưng</span>';
                break;
            default:
                return '<span class="badge bg-secondary">Không xác định</span>';
                break;
        }
    }
}
