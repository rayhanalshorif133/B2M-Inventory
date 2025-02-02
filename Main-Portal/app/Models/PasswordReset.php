<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    protected $table = 'password_resets';

    protected $fillable = [
            'user_id',
            'email',
            'token',
            'email_send',
            'verify_status',
            'description',
            'created_at',
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
}
