<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChuyenMuc extends Model
{
    protected $table = 'chuyen_muc';

    protected $fillable = [
        'ten',
        'slug',
        'type',
        'trangthai',
        'daxoa'
    ];

    public function getType()
    {
        switch ($this->type) {
            case '0':
                return '<span class="badge bg-info">Giới thiệu</span>';
                break;
            case '1':
                return '<span class="badge bg-info">Dịch vụ</span>';
                break;
            case '2':
                return '<span class="badge bg-info ">Tin tức - Tuyển dụng</span>';
                break;
            default:
                return '<span class="badge bg-secondary">Không xác định</span>';
                break;
        }
    }

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

    // public function tinBai() {
    //     return $this->hasMany(TinTuc::class, 'chuyenmuc_id');
    // }

    public function tinTucs()
    {
        return $this->belongsToMany(TinTuc::class, 'tintuc_chuyenmuc', 'chuyenmuc_id', 'tintuc_id');
    }
}
