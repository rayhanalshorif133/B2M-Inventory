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

        if ($request->supplier_id) {
            $supplier = Supplier::select()->where('id', $request->supplier_id)->first();
            return $this->respondWithSuccess('Successfully fetched supplier data', $supplier);
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


    public function update(Request $request)
    {
        try {
            // Find the supplier by ID
            $supplier = Supplier::find($request->id);

            // If the supplier doesn't exist, return an error
            if (!$supplier) {
                return $this->respondWithError('error', 'Supplier not found.');
            }

            // Update the supplier's details
            $supplier->name = $request->name;
            $supplier->contact = $request->contact;
            $supplier->address = $request->address;
            $supplier->email = $request->email;
            $supplier->others_info = $request->others_info;
            $supplier->company_id = Auth::user()->company_id;
            $supplier->save();

            return $this->respondWithSuccess('success', 'Supplier updated successfully');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', $th->getMessage());
        }
    }


    public function delete($id)
    {
        try {
            // Find the supplier by ID
            $supplier = Supplier::find($id);
            if (!$supplier) {
                return $this->respondWithError('error', 'Supplier not found.');
            }

            $supplier->status = $supplier->status == 0 ? 1 : 0; // Assuming 0 means deleted or inactive
            $supplier->save();

            return $this->respondWithSuccess('success', 'Supplier deleted successfully');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Something went wrong.');
        }
    }
}
