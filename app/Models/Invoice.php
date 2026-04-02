<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PhpParser\Node\Expr\Cast;

class Invoice extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'tanggal_terbit' => 'datetime',
        'tanggal_bayar' => 'datetime',
        'total' => 'decimal:2',
    ];
    protected $with = ['user'];


    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
