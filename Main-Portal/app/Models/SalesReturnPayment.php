<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReturnPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_return_id',
        'transaction_type_id',
        'company_id',
        'amount',
        'receipt_no',
        'customer_id',
        'added_by',
        'created_date',
    ];



    public function salesReturn(){
        return $this->belongsTo(SalesReturn::class,'sales_return_id','id');
    }

    public function addedBy(){
        return $this->belongsTo(User::class,'added_by','id');
    }

    public function transactionType(){
        return $this->belongsTo(TransactionType::class,'transaction_type_id','id');
    }
}
