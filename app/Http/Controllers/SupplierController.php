<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{


    public function list(Request $request)
    {
        if ($request->type == 'fetch' && request()->ajax()) {

            $suppliers = Supplier::select()->where('company_id', Auth::user()->company_id)->get();
            return DataTables::of($suppliers)->toJson();
        }

        return view('supplier.list');
    }




    public function fetch(Request $request)
    {
        if ($request->type == 'purchase-return') {
            $purchases = Purchase::select()
                ->where('company_id', Auth::user()->company_id)
                ->where('invoice_date', $request->date)
                ->with('supplier')
                ->get();
            return $this->respondWithSuccess('Successfully fetched purchases data', $purchases);
        }
        $suppliers = Supplier::select('id', 'name')->where('company_id', Auth::user()->company_id)->get();
        return $this->respondWithSuccess('Successfully fetched supplier data', $suppliers);
    }

    public function create(Request $request)
    {
        try {

            if ($request['name'] == null || $request['contact'] == null) {
                return $this->respondWithError('error', 'Name and contact are required.!');
            }

            $supplier = new Supplier();
            $supplier->name = $request['name'];
            $supplier->contact = $request['contact'];
            $supplier->address = $request['address'];
            $supplier->email = $request['email'];
            $supplier->others_info = $request['others_info'];
            $supplier->added_by = Auth::user()->id;
            $supplier->company_id = Auth::user()->company_id;
            $supplier->save();

            return $this->respondWithSuccess('success', 'Supplier created successfully');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Something wents wrong.!');
        }
    }
}
