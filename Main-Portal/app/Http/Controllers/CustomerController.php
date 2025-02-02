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

            $customers = Customer::select()->where('company_id', Auth::user()->company_id)->get();
            return DataTables::of($customers)->toJson();
        }

        return view('customer.list');
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
        } else if ($request->type == 'sales-return') {
            $sales = Sales::select()
                ->where('company_id', Auth::user()->company_id)
                ->where('invoice_date', $request->date)
                ->with('customer')
                ->get();
            return $this->respondWithSuccess('Successfully fetched sales data', $sales);
        }


        if ($request->customer_id) {
            $customer = Customer::select()->where('id', $request->customer_id)->first();
            return $this->respondWithSuccess('Successfully fetched customer data', $customer);
        }

        $customers = Customer::select('id', 'name')->where('company_id', Auth::user()->company_id)->get();
        return $this->respondWithSuccess('Successfully fetched customers data', $customers);
    }

    public function create(Request $request)
    {
        try {

            if ($request['name'] == null || $request['contact'] == null) {
                return $this->respondWithError('error', 'Name and contact are required.!');
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
            return $this->respondWithError('error', 'Something wents wrong.!');
        }
    }

    public function update(Request $request)
    {
        try {

            // Find the customer by ID
            $customer = Customer::find($request->id);

            // If the customer doesn't exist, return an error
            if (!$customer) {
                return $this->respondWithError('error', 'Customer not found.');
            }

            // Update the customer's details
            $customer->name = $request->name;
            $customer->contact = $request->contact;
            $customer->address = $request->address;
            $customer->email = $request->email;
            $customer->others_info = $request->others_info;
            $customer->company_id = Auth::user()->company_id;
            $customer->save();

            return $this->respondWithSuccess('success', 'Customer updated successfully');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', $th->getMessage());
            return $this->respondWithError('error', 'Something went wrong.!');
        }
    }

    public function delete($id)
    {
        try {
            // Find the customer by ID
            $customer = Customer::find($id);
            if (!$customer) {
                return $this->respondWithError('error', 'Customer not found.');
            }

            $customer->status = $customer->status == 0 ? 1 : 0; // Assuming 0 means deleted or inactive
            $customer->save();

            return $this->respondWithSuccess('success', 'Customer deleted successfully');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Something went wrong.!');
        }
    }
}
