<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpensesIncomeCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'status',
        'created_by',
    ];


    public function company(){
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function addedBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }
}
