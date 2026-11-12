<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationLelang extends Model
{
    protected $guarded = ['id'];
    protected $with = ['lelang'];

    public function lelang() : BelongsTo
    {
        return $this->belongsTo(Lelang::class,'lelang_id', 'kode_rup');
    }
}
