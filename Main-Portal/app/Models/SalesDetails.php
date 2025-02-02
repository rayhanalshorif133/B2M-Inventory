<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_id',
        'product_id',
        'product_attribute_id',
        'qty',
        'sales_rate',
        'discount',
        'total',
        'current_unit_cost',
        'created_time',
        'created_date',
    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id', 'id');
    }

    public function productAttribute(){
        return $this->belongsTo(ProductAttribute::class,'product_attribute_id', 'id');
    }

    public function sales(){
        return $this->belongsTo(Sales::class,'sales_id', 'id');
    }

}
