<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fokus extends Model
{
    protected $guarded = ['id'];
    protected $table = 'fokus_tenders';
    protected $with = ['lpse','tender'];

    public function lpse() : BelongsTo
    {
        return $this->belongsTo(Lpse::class, 'lpse_id', 'id');
    }

    public function tender() : BelongsTo
    {
        return $this->belongsTo(Tender::class);
    }
}
