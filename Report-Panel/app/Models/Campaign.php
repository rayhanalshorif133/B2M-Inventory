<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;


    protected $table = 'campaigns'; // Explicitly define the table if it's different from the plural of the model name

    protected $fillable = [
        'name',
        'amount',
        'start_date',
        'banner',
        'start_time',
        'game_keyword',
        'game_id',
        'end_date',
        'end_time',
        'status',
        'participation',
        'description',
        'created_by',
        'updated_by'
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
    ];


    public function incrementParticipation()
    {
        $this->participation = intval($this->participation) + 1;
        $this->save();
    }


    public function calculateTimeForCampaign($campaign)
    {
        $start = $campaign->start_date;
        $end = $campaign->end_date;
        $now = now();
        if ($now->gt($start) && $now->lt($end)) {
            $campaign->time_status = 'End in ';
            // calculate time left
            $remaining = $now->diff($end);
            $campaign->day_left = $remaining->format('%a');
            $campaign->time_h_left = $remaining->format('%H');
            $campaign->time_m_left = $remaining->format('%I');
        } elseif ($now->lt($start)) {
            $campaign->time_status = 'upcoming';
            // Calculate time until the campaign starts
            $time_until_start = $now->diff($start);
            $campaign->day_left = $time_until_start->format('%a');
            $campaign->time_h_left = $time_until_start->format('%H');
            $campaign->time_m_left = $time_until_start->format('%I');
        } else {
            $campaign->time_status = 'Expired';
            // calculate time left
            $time_since_end = $end->diff($now);
            $campaign->day_left = $time_since_end->format('%a');
            $campaign->time_h_left = $time_since_end->format('%H');
            $campaign->time_m_left = $time_since_end->format('%I');
        }
        return $campaign;
    }
}
