<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargeLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'campaign_id',
        'msisdn',
        'keyword',
        'amount',
        'type',
        'charge_date',
    ];

}
