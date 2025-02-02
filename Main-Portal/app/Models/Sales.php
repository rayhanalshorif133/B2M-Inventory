<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'company_id',
        'customer_id',
        'code',
        'invoice_date',
        'status',
        'total_amount',
        'sub_amount',
        'discount',
        'grand_total',
        'paid_amount',
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
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }


}
