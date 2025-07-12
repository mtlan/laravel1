<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HdvdlDmNgonNgu extends Model
{
    use HasFactory;

    protected $table = 'hdvdl_dm_ngonngu';

    protected $fillable = [
        'ten',
        'ma',
        'trangthai',
        'daxoa'
    ];
}
