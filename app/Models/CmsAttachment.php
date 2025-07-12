<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsAttachment extends Model
{
    use HasFactory;

    protected $table = 'cms_attachment';

    protected $fillable = [
        'company_id',
        'dangkythongtin_id',
        'is_giahan',
        'group_id',
        'user_id',
        'huongdanvien_id',
        'tintuc_id',
        'ten',
        'original_name',
        'url',
        'mime',
        'size',
        'type',
        'object_id',
        'folder_id',
        'ghichu',
        'trangthai',
        'nguoitao',
        'nguoicapnhat',
        'ngaytao',
        'ngaycapnhat',
        'daxoa',
    ];

    public function huongDanVien()
    {
        return $this->belongsTo('App\Models\HdvdlHuongDanVien', 'huongdanvien_id');
    }

    public function dangkythongtin()
    {
        return $this->belongsTo('App\Models\HdvdlDangKyThongTin', 'dangkythongtin_id');
    }

    public function tinTuc()
    {
        return $this->belongsTo(TinTuc::class, 'tintuc_id');
    }
}
