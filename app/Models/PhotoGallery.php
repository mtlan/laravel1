<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoGallery extends Model
{
    protected $fillable = [
        'ten',
        'original_name',
        'url',
        'parent_id',
        'children_id',
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

    public function children()
    {
        return $this->belongsTo(SubFolder::class, 'children_id');
    }

    public function parent()
    {
        return $this->belongsTo(ParentDirectory::class, 'parent_id');
    }
}
