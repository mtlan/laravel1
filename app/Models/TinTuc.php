<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TinTuc extends Model
{
    protected $table = 'tin_tuc';

    protected $fillable = [
        'ten',
        'slug',
        'mota',
        'noidung',
        'filedinhkem',
        'hinhanh',
        'tukhoa',
        'luotxem',
        'noibat',
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

    // public function chuyenMuc()
    // {
    //     return $this->belongsTo(ChuyenMuc::class, 'chuyenmuc_id');
    // }

    public function chuyenMucs()
    {
        return $this->belongsToMany(ChuyenMuc::class, 'tintuc_chuyenmuc', 'tintuc_id', 'chuyenmuc_id');
    }

    public function attachments()
    {
        return $this->hasMany(CmsAttachment::class, 'tintuc_id');
    }
}
