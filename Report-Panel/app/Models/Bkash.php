<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bkash extends Model
{
    use HasFactory;

    protected $table = 'bkashes';

    protected $fillable = [
        'username',
        'password',
        'mobile_number',
        'status',
        'id_token',
        'response',
    ];

    protected $casts = [
        'response' => 'array', // Automatically casts JSON field to an array
    ];




    public function generateToken($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $token;
    }
}
