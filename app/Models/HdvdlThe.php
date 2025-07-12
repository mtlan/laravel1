<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HdvdlThe extends Model
{
    use HasFactory;

    protected $table = 'hdvdl_the';

    protected $fillable = [
        'huongdanvien_id',
        'huongdan_tiengchinh',
        'sothe',
        'noicapthe_id',
        'thoihanthe_id',
        'tungay',
        'denngay',
        'trangthai',
        'daxoa',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tungay' => 'date',
        'denngay' => 'date',
    ];

    public function tiengchinh()
    {
        return $this->hasOne('App\Models\HdvdlDmNgonNgu', 'id', 'huongdan_tiengchinh');
    }

    public function noicapthe()
    {
        return $this->hasOne('App\Models\HdvdlDmNoiCapThe', 'id', 'noicapthe_id');
    }

    public function thoihanthe()
    {
        return $this->hasOne('App\Models\HdvdlDmThoiHanThe', 'id', 'thoihanthe_id');
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

    public function huongdanvien()
    {
        return $this->belongsTo('App\Models\HdvdlHuongDanVien', 'huongdanvien_id', 'id');
    }
}
