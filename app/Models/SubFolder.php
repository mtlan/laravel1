<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubFolder extends Model
{
    protected $fillable = [
        'ten',
        'slug',
        'parent_id',
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

    public function thuMucCha()
    {
        return $this->belongsTo(ParentDirectory::class, 'parent_id');
    }

    public function thuVienAnh()
    {
        return $this->hasMany(PhotoGallery::class, 'children_id');
    }
}
