<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $guarded = ['id'];
    // protected $with = ['users'];

    // public function users()
    // {
    //     return $this->hasMany(User::class, 'group_id');
    // }
}
