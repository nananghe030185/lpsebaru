<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $guarded = ['id'];
    protected $table = 'notifications';
    protected $with = ['tender'];

    public function tender() : BelongsTo
    {
        return $this->belongsTo(Tender::class);
    }
}
