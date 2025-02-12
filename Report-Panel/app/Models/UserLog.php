<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;

    protected $table = 'users_logs';

    protected $fillable = [
        'name',
        'msisdn',
        'email',
        'created_date',
        'created_time',
        'last_login_date',
        'last_login_time'
    ];
}
