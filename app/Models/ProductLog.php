<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLog extends Model
{
    use HasFactory;



    protected $fillable = [
        'product_attribute_id',
        'type',
        'qty',
        'opt_date',
        'ref_id'
    ];



    public function productAttribute(){
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id', 'id');
    }

}
