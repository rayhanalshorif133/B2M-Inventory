<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturnDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_returns_id',
        'purchase_details_id',
        'product_attribute_id',
        'return_qty',
        'discount',
        'purchase_rate',
        'total',
        'created_time',
        'created_date',
    ];


    public function purchaseDetails(){
        return $this->belongsTo(PurchaseDetails::class,'purchase_details_id', 'id');
    }


    public function productAttribute(){
        return $this->belongsTo(ProductAttribute::class,'product_attribute_id', 'id');
    }

    public function purchaseReturn(){
        return $this->belongsTo(PurchaseReturn::class,'purchase_returns_id', 'id');
    }



}
