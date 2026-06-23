<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class P2kpItem extends Model
{
    protected $table = 'p2kp_items';

    protected $fillable = [
        'p2kp_id',
        'activity',
        'credit_score',
        'real_credit_score',
        'target_qty',
        'target_output',
        'real_output',
        'target_quality',
        'target_time',
        'target_time_unit',
        'real_time_unit',
        'real_qty',
        'real_quality',
        'real_time',
        'real_cost',
        'type',
        'order',
    ];

    public function p2kp()
    {
        return $this->belongsTo(P2kp::class);
    }
}
