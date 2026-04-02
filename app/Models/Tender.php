<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    protected $guarded = ['id'];
    protected $with = ['lpse'];

    public function lpse()
    {
        return $this->belongsTo(Lpse::class, 'lpse_id');
    }
}
