<?php

namespace App\Http\Controllers;

use App\Models\TransactionType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionTypeController extends Controller
{
    public function index(){
        if (request()->ajax()) {
            $query = TransactionType::orderBy('created_at', 'desc')->with('addedBy')->get();
            return DataTables::of($query)->toJson();
        }
        return view('transactionType.index');
    }

    public function fetch(){
        $transactionTypes = TransactionType::select('id','name')->get();
        return $this->respondWithSuccess('Successfully fetched transaction types data', $transactionTypes);
    }
}
