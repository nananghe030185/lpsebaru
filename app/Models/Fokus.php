<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fokus extends Model
{
    protected $guarded = ['id'];
    protected $table = 'fokus_tenders';
    protected $with = ['tender'];

    public function tender() : BelongsTo
    {
        return $this->belongsTo(Tender::class, 'tender_id', 'tender_id');
    }
}
