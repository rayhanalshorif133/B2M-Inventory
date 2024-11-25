<?php

namespace App\Http\Controllers;

use App\Models\TipsAndTour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipsAndTourController extends Controller
{
    public function __construct()
    {
        $this->checkAuth();
    }

    public function fetchTipsAndSkipsTourGuide()
    {
        $GETDATA = TipsAndTour::select()->where('user_id', Auth::user()->id)->first();
        return $this->respondWithSuccess('Successfully fetched tips and skipped', $GETDATA);
    }

    public function update(Request $request)
    {
        $tipsAndTour = TipsAndTour::select()->where('user_id', Auth::user()->id)->first();
        $tipsAndTour->is_viewed = true;
        $tipsAndTour->save();
        return $this->respondWithSuccess('success', 'Successfully updated tips and skipped guide data');
    }
}
