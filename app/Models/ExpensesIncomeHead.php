<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpensesIncomeHead extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'expenses_income_categories_id',
        'name',
        'status',
        'created_by',
    ];




    public function expensesIncomeCategories()
    {
        return $this->belongsTo(ExpensesIncomeCategory::class, 'expenses_income_categories_id', 'id');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }


    public function addedBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }

}
