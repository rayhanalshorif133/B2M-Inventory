<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCreate extends Model
{
    use HasFactory;


    protected $fillable = [
        'invoice_no',
        'user_msisdn',
        'keyword',
        'status',
        'bkash_msisdn',
        'date',
        'amount',
        'token',
        'campaign_id',
        'response',
        'payment_id'
    ];
}
