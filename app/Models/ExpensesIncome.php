<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpensesIncome extends Model
{
    use HasFactory;


    protected $fillable = [
        'company_id',
        'expenses_income_categories_id',
        'expenses_income_heads_id',
        'type',
        'date',
        'transaction_type_id',
        'amount',
        'status',
        'note',
        'created_by',
    ];


    public function company(){
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function addedBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function transactionType(){
        return $this->belongsTo(TransactionType::class,'transaction_type_id','id');
    }


    public function expensesIncomeHead(){
        return $this->belongsTo(ExpensesIncomeHead::class, 'expenses_income_heads_id', 'id');
    }

    public function expensesIncomeCategory(){
        return $this->belongsTo(ExpensesIncomeCategory::class, 'expenses_income_categories_id', 'id');
    }



}
