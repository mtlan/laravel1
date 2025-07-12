<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HdvdlHuongDanTiengPhu extends Model
{
    use HasFactory;

    protected $table = 'hdvdl_huongdan_tiengphu';

    protected $fillable = [
        'huongdanvien_id',
        'ngonngu_id',
        'trangthai',
        'daxoa',
    ];

    public function huongdanvien()
    {
        return $this->belongsTo('App\Models\HdvdlHuongDanVien', 'huongdanvien_id');
    }
}
