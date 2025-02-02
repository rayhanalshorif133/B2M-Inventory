<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'contact',
        'address',
        'email',
        'company_id',
        'others_info',
        'status',
        'added_by',
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
