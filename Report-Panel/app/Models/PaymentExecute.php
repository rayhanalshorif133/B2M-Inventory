<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentExecute extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'payment_create_id',
        'invoice_no',
        'payment_id',
        'user_msisdn',
        'bkash_msisdn',
        'amount',
        'trxID',
        'date',
        'keyword',
        'transaction_status',
        'error_code',
        'error_message',
        'response',
    ];

}
