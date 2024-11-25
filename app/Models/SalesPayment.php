<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_id',
        'transaction_type_id',
        'amount',
        'customer_id',
        'company_id',
        'discount',
        'added_by',
        'receipt_no',
        'created_date',
    ];

    public function sales(){
        return $this->belongsTo(Sales::class,'sales_id','id');

    }

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');

    }

    public function addedBy(){
        return $this->belongsTo(User::class,'added_by','id');
    }

    public function transactionType(){
        return $this->belongsTo(TransactionType::class,'transaction_type_id','id');
    }
}
