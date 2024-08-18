<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchases_id',
        'transaction_type_id',
        'amount',
        'supplier_id',
        'company_id',
        'discount',
        'added_by',
        'receipt_no',
        'created_date',
    ];

    public function purchase(){
        return $this->belongsTo(Purchase::class,'purchases_id','id');

    }

    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id');

    }

    public function addedBy(){
        return $this->belongsTo(User::class,'added_by','id');
    }

    public function transactionType(){
        return $this->belongsTo(TransactionType::class,'transaction_type_id','id');
    }

    public $timestamps = false;
}
