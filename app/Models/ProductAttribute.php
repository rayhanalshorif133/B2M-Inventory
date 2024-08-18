<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'company_id',
        'code',
        'size',
        'color',
        'current_stock',
        'last_purchase',
        'model',
        'sales_rate',
        'unit_cost'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

}
