<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lelang extends Model
{
    protected $guarded = ['id'];

    public function isfokus()
    {
        return true;
    }
}
