<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkirTransaksi extends Model
{
    protected $table = 'parkir_transaksis';

    protected $fillable = [
        'card_id',
        'checkin_time',
        'checkout_time',
        'duration',
        'fee',
        'status',
    ];

    protected $casts = [
        'checkin_time' => 'datetime',
        'checkout_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}

