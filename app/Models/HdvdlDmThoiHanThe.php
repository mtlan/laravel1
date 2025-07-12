<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HdvdlDmThoiHanThe extends Model
{
    use HasFactory;

    protected $table = 'hdvdl_dm_thoihanthe';

    protected $fillable = [
        'ten',
        'ma',
        'trangthai',
        'daxoa'
    ];
}
