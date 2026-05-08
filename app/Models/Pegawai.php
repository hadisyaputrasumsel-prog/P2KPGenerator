<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pegawai extends Model
{
    protected $guarded = [];

    public function p2kps(): HasMany
    {
        return $this->hasMany(P2kp::class, 'employee_id');
    }
}
