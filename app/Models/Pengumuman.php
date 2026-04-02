<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    //
    protected $guarded = [];
    protected $table = 'pengumuman';

    protected $casts = [
        'expire' => 'datetime',
    ];
}
