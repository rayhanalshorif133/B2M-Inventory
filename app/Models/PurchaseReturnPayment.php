<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturnPayment extends Model
{
    use HasFactory;


    protected $fillable = [
        'purchase_return_id',
        'transaction_type_id',
        'company_id',
        'amount',
        'receipt_no',
        'supplier_id',
        'added_by',
        'created_date',
    ];



    public function purchaseReturn(){
        return $this->belongsTo(PurchaseReturn::class,'purchase_return_id','id');
    }

    public function addedBy(){
        return $this->belongsTo(User::class,'added_by','id');
    }

    public function transactionType(){
        return $this->belongsTo(TransactionType::class,'transaction_type_id','id');
    }


}
