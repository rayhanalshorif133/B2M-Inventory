<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;


class LedgerController extends Controller
{
    public function customer(Request $request)
    {
        if ($request->type == 'fetch' && request()->ajax()) {
            $query = Customer::select()
                ->where('company_id', Auth::user()->company_id)
                ->get();
            return DataTables::of($query)->toJson();
        }
        return view('ledger.customer');
    }

    public function supplier(Request $request)
    {
        if ($request->type == 'fetch' && request()->ajax()) {
            $query = Supplier::select()
                ->where('company_id', Auth::user()->company_id)
                ->get();
            return DataTables::of($query)->toJson();
        }
        return view('ledger.supplier');
    }

    public function product(Request $request)
    {
        if ($request->type == 'fetch' && request()->ajax()) {
            $query = Product::select()
                ->where('company_id', Auth::user()->company_id)
                ->get();
            return DataTables::of($query)->toJson();
        }
        return view('ledger.product');
    }
}
