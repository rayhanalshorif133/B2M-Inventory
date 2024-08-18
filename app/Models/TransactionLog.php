<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_type_id',
        'amount',
        'type',
        'opt_date',
        'ref_id'
    ];



    public function transactionType(){
        return $this->belongsTo(TransactionType::class, 'added_by');
    }
}
