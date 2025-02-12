<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitLogDetail extends Model
{
    use HasFactory;

    protected $table = 'visit_logs_details';

    protected $fillable = [
        'visitor_id',
        'page_name',
        'open_time',
        'close_time',
        'duration',
        'page_url',
    ];
}
