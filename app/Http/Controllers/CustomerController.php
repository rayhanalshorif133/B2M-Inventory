<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{

    public function list(Request $request)
    {
        if ($request->type == 'fetch' && request()->ajax()) {

            $suppliers = Customer::select()->where('company_id', Auth::user()->company_id)->get();
            return DataTables::of($suppliers)->toJson();
        }

        return view('customer.list');
    }

    public function fetch(Request $request){
        if($request->type == 'purchase-return'){
            $purchases = Purchase::select()
                ->where('company_id', Auth::user()->company_id)
                ->where('invoice_date', $request->date)
                ->with('supplier')
                ->get();
            return $this->respondWithSuccess('Successfully fetched purchases data', $purchases);
        }else if($request->type == 'sales-return'){
            $sales = Sales::select()
                ->where('company_id', Auth::user()->company_id)
                ->where('invoice_date', $request->date)
                ->with('customer')
                ->get();
            return $this->respondWithSuccess('Successfully fetched sales data', $sales);
        }

        $suppliers = Customer::select('id','name')->where('company_id', Auth::user()->company_id)->get();
        return $this->respondWithSuccess('Successfully fetched supplier data', $suppliers);
    }

    public function create(Request $request){
        try {

            if($request['name'] == null || $request['contact'] == null){
                return $this->respondWithError('error', 'Name and contact are required.!' );
            }

            $customer = new Customer();
            $customer->name = $request['name'];
            $customer->contact = $request['contact'];
            $customer->address = $request['address'];
            $customer->email = $request['email'];
            $customer->others_info = $request['others_info'];
            $customer->added_by = Auth::user()->id;
            $customer->company_id = Auth::user()->company_id;
            $customer->save();

            return $this->respondWithSuccess('success', 'Customer created successfully');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Something wents wrong.!' );
        }
    }
}
