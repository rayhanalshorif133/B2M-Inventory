<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentList extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'serial_no',
        'transaction_type_id',
        'type',
        'amount',
        'opt_date',
        'paid_by',
        'created_by',
        'received_by',
        'ref_id',
    ];
}
