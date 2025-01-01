<?php

namespace App\Http\Controllers;

use App\Models\TransactionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TransactionTypeController extends Controller
{



    public function __construct()
    {
        $this->checkAuth();
    }

    public function index(Request $request)
    {
        if (request()->ajax() && $request->type == 'fetch') {
            $query = TransactionType::where('company_id', Auth::user()->company_id)->orderBy('created_at', 'desc')->with('addedBy')->get();
            return DataTables::of($query)->toJson();
        }
        return view('transactionType.index');
    }

    public function fetch()
    {
        $transactionTypes = TransactionType::select('id', 'name')->get();
        return $this->respondWithSuccess('Successfully fetched transaction types data', $transactionTypes);
    }

    public function createUpdate(Request $request)
    {
        try {


            if($request->type == 'status'){
                $transactionType = TransactionType::where('id', $request->tt_id)->first();
                $transactionType->status = $transactionType->status == 1 ? 0 : 1;
                $transactionType->save();
                return $this->respondWithSuccess('success','Successfully updated transaction type status');
            }

            if($request->method() == 'POST'){
                $transactionTypes = TransactionType::where('name', $request->name)->where('company_id', Auth::user()->company_id)->first();
                if ($transactionTypes) {
                    return $this->respondWithSuccess('error', 'Already added this transaction type');
                }

                $transactionType = new TransactionType();
                $transactionType->name = $request->name;
                $transactionType->company_id = Auth::user()->company_id;
                $transactionType->added_by = Auth::user()->id;
                $transactionType->save();
                return $this->respondWithSuccess('success','Successfully created transaction type');
            }else{
                $transactionType = TransactionType::where('id', $request->tt_id)
                ->where('company_id', Auth::user()->company_id)->first();
                $transactionType->name = $request->name;
                $transactionType->company_id = Auth::user()->company_id;
                $transactionType->added_by = Auth::user()->id;
                $transactionType->save();
                return $this->respondWithSuccess('success','Successfully updated transaction type');
            }
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Could not create transaction type');
        }

    }

    public function delete($tt_id){
        try {
            $transactionType = TransactionType::find($tt_id);
            $transactionType->delete();
            return $this->respondWithSuccess('success','Successfully deleted transaction type');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Could not delete transaction type');
        }
    }
}
