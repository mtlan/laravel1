<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HdvdlHuongDanVien extends Model
{
    use HasFactory;

    protected $table = 'hdvdl_huongdanvien';

    protected $fillable = [
        'ho_tenlot',
        'ten',
        'tendaydu',
        'ngaysinh',
        'gioitinh',
        'sdt1',
        'sdt2',
        'email1',
        'email2',
        'cmnd_so',
        'cmnd_ngaycap',
        'cmnd_noicap',
        'diachi',
        'anhtheBase64',
        'ngaytao',
        'nguoitao',
        'ngaysua',
        'nguoisua',
        'trangthai',
        'daxoa',
    ];

    public function attachment()
    {
        return $this->hasOne('App\Models\CmsAttachment', 'huongdanvien_id')->where('type', 1)->where('daxoa', 0);
    }

    /**
     * Type = 2 là qrcode
     */
    public function qrcode()
    {
        return $this->hasOne('App\Models\CmsAttachment', 'huongdanvien_id')->where('type', 2)->where('daxoa', 0);
    }

    public function tiengphus()
    {
        return $this->hasMany('App\Models\HdvdlHuongDanTiengPhu', 'huongdanvien_id', 'id');
    }

    public function getTrangThai()
    {
        switch ($this->trangthai) {
            case '1':
                return '<span class="badge bg-success">Đang Hoạt động</span>';
                break;
            case '0':
                return '<span class="badge bg-danger ">Tạm nghĩ</span>';
                break;
            default:
                return '<span class="badge bg-secondary">Không xác định</span>';
                break;
        }
    }

    public function getHoVaTen()
    {
        return $this->ho_tenlot . ' ' . $this->ten;
    }

    public function danhsachthe()
    {
        return $this->hasMany('App\Models\HdvdlThe', 'huongdanvien_id', 'id')->where('daxoa', 0);
    }

    public function thedanghoatdong()
    {
        return $this->hasOne('App\Models\HdvdlThe', 'huongdanvien_id', 'id')->where('trangthai', 1)->where('daxoa', 0);
    }

    public function thegannhat()
    {
        return $this->hasOne('App\Models\HdvdlThe', 'huongdanvien_id', 'id')
            ->where('daxoa', 0)
            ->orderBy('created_at', 'desc');
    }

    /**
     * Tính toán ngày mặc định cho thẻ mới dựa trên thẻ gần nhất
     * @return string|null Ngày mặc định theo định dạng d/m/Y hoặc null nếu không có thẻ nào
     */
    public function getDefaultCardStartDate()
    {
        $theGanNhat = $this->thegannhat;

        if (!$theGanNhat || !$theGanNhat->denngay) {
            return null;
        }

        // Lấy ngày tiếp theo của ngày kết thúc thẻ gần nhất
        $ngayTiepTheo = Carbon::parse($theGanNhat->denngay)->addDay();

        return $ngayTiepTheo->format('d/m/Y');
    }
}
