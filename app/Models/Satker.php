<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Satker extends Model
{
    protected $guarded = ['id'];
    protected $with = ['klpdi'];
    
    public function klpdi() : BelongsTo
    {
        return $this->belongsTo(Klpdi::class,'kode_klpd','kode_klpdi');
    }
}
