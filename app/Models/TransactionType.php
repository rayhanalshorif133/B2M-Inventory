<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'added_by',
    ];

    public function addedBy(){
        return $this->belongsTo(User::class, 'added_by');
    }
}
