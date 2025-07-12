<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HdvdlDangKyThongTin extends Model
{
    use HasFactory;

    protected $table = 'hdvdl_dangkythongtin';

    protected $fillable = [
        'ho_tenlot',
        'ten',
        'ngaysinh',
        'gioitinh',
        'sdt1',
        'email1',
        'cmnd_so',
        'cmnd_ngaycap',
        'cmnd_noicap',
        'diachi',
        'huongdan_tiengchinh',
        'sothe',
        'noicapthe_id',
        'thoihanthe_id',
        'tungay',
        'denngay',
        'trangthai',
        'type',
        'huongdanvien_id',
        'daxoa',
    ];

    public function getType()
    {
        switch ($this->type) {
            case 'tao_moi':
                return '<span class="badge bg-primary">Tạo mới</span>';
                break;
            case 'chinh_sua':
                return '<span class="badge bg-warning">Chỉnh sửa</span>';
                break;
            case 'gia_han':
                return '<span class="badge bg-secondary ">Gia hạn</span>';
                break;
            default:
                return '<span class="badge bg-warning">Không xác định</span>';
                break;
        }
    }

    public function getTrangThai()
    {
        switch ($this->trangthai) {
            case 'cho_phe_duyet':
                return '<span class="badge bg-primary">Chờ phê duyệt</span>';
                break;
            case 'da_phe_duyet':
                return '<span class="badge bg-success">Đã phê duyệt</span>';
                break;
            case 'da_huy':
                return '<span class="badge bg-danger ">Đã hủy</span>';
                break;
            default:
                return '<span class="badge bg-warning">Không xác định</span>';
                break;
        }
    }

    public function huongdanvien()
    {
        return $this->hasOne('App\Models\HdvdlHuongDanVien', 'id', 'huongdanvien_id');
    }

    public function noicapthe()
    {
        return $this->hasOne('App\Models\HdvdlDmNoiCapThe', 'id', 'noicapthe_id');
    }

    public function thoihanthe()
    {
        return $this->hasOne('App\Models\HdvdlDmThoiHanThe', 'id', 'thoihanthe_id');
    }

    public function tiengchinh()
    {
        return $this->hasOne('App\Models\HdvdlDmNgonNgu', 'id', 'huongdan_tiengchinh');
    }

    public function attachment()
    {
        return $this->hasOne('App\Models\CmsAttachment', 'dangkythongtin_id');
    }
}
