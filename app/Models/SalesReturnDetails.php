<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReturnDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_returns_id',
        'sales_details_id',
        'product_attribute_id',
        'return_qty',
        'discount',
        'sales_rate',
        'total',
        'created_time',
        'created_date',
    ];

    public function salesDetails()
    {
        return $this->belongsTo(SalesDetails::class, 'sales_details_id', 'id');
    }


    public function productAttribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id', 'id');
    }

    public function salesReturn()
    {
        return $this->belongsTo(SalesReturn::class, 'sales_returns_id', 'id');
    }
}
