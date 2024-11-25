<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'customer_id',
        'sales_id',
        'invoice_date',
        'code',
        'status',
        'total_amount',
        'return_amount',
        'due_amount',
        'note',
        'created_by',
        'created_time',
        'created_date',
    ];


    public function company(){
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    public function customer(){
        return $this->belongsTo(Supplier::class, 'customer_id', 'id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function sales(){
        return $this->belongsTo(Sales::class, 'sales_id', 'id');
    }

}
