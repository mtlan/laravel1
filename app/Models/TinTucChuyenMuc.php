<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TinTucChuyenMuc extends Model
{
    protected $table = 'tintuc_chuyenmuc';

    protected $fillable = [
        'tintuc_id',
        'chuyenmuc_id',
    ];
}
