<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'supplier_id',
        'code',
        'invoice_date',
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
    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }




    public $timestamps = true;
}
