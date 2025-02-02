<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Game;
use App\Models\Subscription;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Campaign::orderBy('created_at', 'desc')
                ->get()
                ->map(function ($campaign) {
                    $campaign->type = $this->isActiveCampaign($campaign->id);
                    return $campaign;
                });
            return DataTables::of($query)
                ->addIndexColumn()
                ->toJson();
        }

        $games = Game::select()->where('status', 1)->get();
        return view('campaign.index', compact('games'));
    }

    public function fetch(Request $request, $id)
    {
        $campaign = Campaign::orderBy('created_at', 'desc')
            ->where('id', $id)
            ->first();

        $campaign = $campaign->calculateTimeForCampaign($campaign);


        $campaign->type = $this->isActiveCampaign($id);

        $game = Game::select()->where('status', 1)->where('id', $campaign->game_id)->first();

        if (!$game) {
            $game = Game::select()->where('status', 1)->where('keyword', $campaign->game_keyword)->first();
        }

        $campaign->game = $game;
        $campaign->user = Auth::user();

        $campaign->hasSubs = false;
        if ($request->msisdn) {
            $date = date('Y-m-d');
            $campaign->hasSubs = Subscription::select()
                ->where('msisdn', $request->msisdn)
                ->where('campaign_id', $campaign->id)
                ->where('subs_date', $date)
                ->where('status', 1)
                ->first();
        }

        return $this->respondWithSuccess('Successfully fetched campaign', $campaign);
    }

    public function fetchLeaderboard(Request $request, $id)
    {

        $date = date('Y-m-d');
        $scores = Score::select('msisdn', DB::raw('SUM(score) as total_score'))
            ->join('campaigns', 'campaigns.id', '=', 'scores.campaign_id')
            ->where('scores.status', '=', 1)
            ->where('campaigns.id', '=', $id)
            ->whereDate('scores.date_time', '=', $date)
            ->groupBy('msisdn', 'campaign_id', 'campaigns.status')
            ->orderBy('total_score', 'desc')
            ->get()
            ->take(20);

        $weekly_scores = Score::select(
            'scores.msisdn',
            DB::raw('SUM(scores.score) as total_score'),
            DB::raw('(
                    SELECT COUNT(DISTINCT DATE(sub_scores.date_time))
                    FROM scores AS sub_scores
                    WHERE sub_scores.campaign_id = scores.campaign_id
                      AND sub_scores.msisdn = scores.msisdn
                      AND sub_scores.status = 1
                      AND sub_scores.subscription_id != ""
                      AND sub_scores.score IS NOT NULL
                ) as participation_count')
        )
            ->join('campaigns', 'campaigns.id', '=', 'scores.campaign_id')
            ->where('scores.status', '=', 1)
            ->where('campaigns.id', '=', $id)
            ->groupBy('scores.msisdn', 'scores.campaign_id')
            ->orderBy('total_score', 'desc')
            ->take(20)
            ->get();

        $data = [
            'daily' => $scores,
            'user' => Auth::user(),
            'weekly' => $weekly_scores
        ];
        return $this->respondWithSuccess('Successfully fetched campaign', $data);
    }


    public function create(Request $request)
    {
        try {


            $start_date_time = Carbon::createFromFormat('Y-m-d\TH:i',  $request->start_date_time);
            $end_date_time = Carbon::createFromFormat('Y-m-d\TH:i',  $request->end_date_time);

            $campaign = new Campaign();
            $campaign->start_date = $start_date_time->toDateString();
            $campaign->start_time = $start_date_time->toTimeString();
            $campaign->end_date = $end_date_time->toDateString();
            $campaign->end_time = $end_date_time->toTimeString();
            $campaign->name = $request->name;
            $campaign->amount = $request->amount;
            if ($request->banner) {
                $image = $request->file('banner');
                $image_name = time() . '_' . $image->getClientOriginalName();

                $image->move(public_path('/images/campaign'), $image_name);
                $campaign->banner = '/images/campaign/' . $image_name;
            }

            $findGame = Game::find($request->game_id);
            $campaign->game_id = $request->game_id;
            if ($findGame) {
                $campaign->game_keyword = $findGame->keyword;
            }
            $campaign->save();

            Session::flash('success', 'Campaign created successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            Session::flash('error', 'Something went wrong');
            return redirect()->back();
        }
    }
}
