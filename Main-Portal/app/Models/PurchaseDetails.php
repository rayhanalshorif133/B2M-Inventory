<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchases_id',
        'product_id',
        'product_attribute_id',
        'qty',
        'purchase_rate',
        'sales_rate',
        'discount',
        'total',
        'created_time',
        'created_date',
    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id', 'id');
    }

    public function productAttribute(){
        return $this->belongsTo(ProductAttribute::class,'product_attribute_id', 'id');
    }

    public function purchase(){
        return $this->belongsTo(Purchase::class,'purchases_id', 'id');
    }

    public $timestamps = true;
}
