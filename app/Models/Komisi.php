<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komisi extends Model
{
    protected $guarded = [];
    protected $with = ['upline', 'downline'];

    public function upline()
    {
        return $this->belongsTo(User::class, 'id_upline');
    }

    public function downline()
    {
        return $this->belongsTo(User::class, 'id_downline');
    }
}
