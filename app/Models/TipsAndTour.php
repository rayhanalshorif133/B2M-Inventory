<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipsAndTour extends Model
{
    use HasFactory;

     // Table name

    // Fillable properties
    protected $fillable = [
        'user_id',
        'company_id',
        'is_viewed',
        'is_skipped',
        'is_favorite',
        'first_viewed_at',
        'last_viewed_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
