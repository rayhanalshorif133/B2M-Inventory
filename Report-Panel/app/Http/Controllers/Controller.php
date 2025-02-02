<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Campaign;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;



    protected function respondWithSuccess($message = '', $data = [], $code = 200)
    {
        return response()->json([
            'status'   => true,
            'errors'  => false,
            'message'  => $message,
            'data'     => $data
        ], $code);
    }
    protected function respondWithError($message, $data = [], $code = 203)
    {
        return response()->json([
            'status'   => false,
            'errors'  => true,
            'message'  => $message,
            'data'     => $data
        ], $code);
    }



    public function getCurrentCampaign($id = null)
    {
        $date = date('Y-m-d');
        $campaign = Campaign::where('status', 1)
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->first();
        return $campaign;

        if ($id) {
            $campaign = Campaign::where('status', 1)
                ->where('id', $id)
                ->where('start_date', '<=', $date)
                ->where('end_date', '>=', $date)
                ->first();
        }
    }

    public function isActiveCampaign($id = null)
    {
        $date = date('Y-m-d');
        if ($id) {
            $campaign = Campaign::where('status', 1)
                ->where('id', $id)
                ->where('start_date', '<=', $date)
                ->where('end_date', '>=', $date)
                ->first();

            if ($campaign) {
                return 'active';
            } else {
                return 'inactive';
            }
        }
    }



}
