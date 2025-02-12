<?php

namespace App\Http\Controllers;

use App\Models\UserLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    // userLogs
    public function userLogs(Request $request)
    {
        if (request()->ajax()) {
            $query = UserLog::orderBy('created_at', 'desc')->get();
            return DataTables::of($query)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('user.logs');
    }
}
