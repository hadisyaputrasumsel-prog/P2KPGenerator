<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class P2kp extends Model
{
    protected $table = 'p2kps';

    protected $fillable = [
        'employee_id',
        'rating_official_id',
        'higher_official_id',
        'period_start',
        'period_end',
        'location',
        'date_signed',
        'service_orientation',
        'integrity',
        'commitment',
        'discipline',
        'cooperation',
        'leadership',
        'recommendation',
        'objection',
        'response',
        'decision',
    ];

    public function employee()
    {
        return $this->belongsTo(Pegawai::class, 'employee_id');
    }

    public function ratingOfficial()
    {
        return $this->belongsTo(Pegawai::class, 'rating_official_id');
    }

    public function higherOfficial()
    {
        return $this->belongsTo(Pegawai::class, 'higher_official_id');
    }

    public function items()
    {
        return $this->hasMany(P2kpItem::class);
    }
}
