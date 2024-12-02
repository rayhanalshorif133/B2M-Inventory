<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Models\SalesDetails;
use App\Models\Sales;
use App\Models\TransactionType;
use App\Models\SalesPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->checkAuth();
    }

    public function index(Request $request)
    {
        if ($request->type == 'fetch' && request()->ajax()) {
            $query = Sales::where('company_id', Auth::user()->company_id)
                ->with('customer')->orderBy('created_at', 'desc')
                ->get();
            return DataTables::of($query)->toJson();
        }
        return view('sales.index');
    }

    public function fetch($id)
    {
        $sales = Sales::where('company_id', Auth::user()->company_id)
            ->where('id', $id)
            ->with('customer')
            ->orderBy('created_at', 'desc')
            ->first();
        $salesDetails = SalesDetails::select()
            ->where('Sales_id', $id)
            ->with('product', 'productAttribute')
            ->get();
        $data = [
            'sales' => $sales,
            'salesDetails' => $salesDetails
        ];
        return $this->respondWithSuccess('Successfully fetched Sales', $data);
    }


    public function create(Request $request)
    {
        if ($request->method() == 'GET') {
            $customers = Customer::select()->where('company_id', Auth::user()->company_id)->get();
            $transactionTypes = TransactionType::select()->where('company_id', Auth::user()->company_id)->get();
            return view('sales.create', compact('customers', 'transactionTypes'));
        }





        DB::beginTransaction();
        try {

            $sales = new Sales();
            $sales->company_id = Auth::user()->company_id;
            $sales->customer_id = $request['customer_id'];
            $sales->code = $this->getSalesCode(Auth::user()->company_id);
            $sales->status = 1;
            $sales->invoice_date = $request['invoice_date'];
            $sales->total_amount = $request['total_amount'];
            $sales->sub_amount = 0;
            $sales->paid_amount = $request['paid_amount'];
            $sales->grand_total = 0;
            $sales->due_amount = floatval($request['total_amount']) - floatval($request['paid_amount']);
            $sales->note = $request['note'];
            $sales->discount = 0;
            $sales->created_by = Auth::user()->id;
            $sales->created_time = date('H:i:s');
            $sales->created_date = date('Y-m-d');
            $sales->save();


            /* <- Sales Payment ->*/
            $salesPayment = new SalesPayment();
            $salesPayment->sales_id = $sales->id;
            $salesPayment->transaction_type_id = $request['transaction_type_id'];
            $salesPayment->amount = $sales->paid_amount;
            $salesPayment->receipt_no = salesPaymentReceiptNo();
            $salesPayment->customer_id = $sales->customer_id;
            $salesPayment->discount = $sales->discount;
            $salesPayment->created_date = $sales->created_date;
            $salesPayment->added_by = Auth::user()->id;
            $salesPayment->company_id = Auth::user()->company_id;
            $salesPayment->save();


            /* <- Sales Payment log send ->*/
            $curl = curl_init();
            $url = url('/api/log/transection?transaction_type_id=' . $salesPayment->transaction_type_id
                . '&type=3&amount=' . $salesPayment->amount . '&ref_id=' . $salesPayment->id);
            // Set cURL options
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response as a string instead of outputting it
            curl_setopt($curl, CURLOPT_TIMEOUT, 3); // Set a timeout for the request (in seconds)
            curl_exec($curl);
            curl_close($curl);



            $productCustomizations =  $request['productCustomizations'];

            foreach ($productCustomizations as $item) {
                $productAttribute  = ProductAttribute::select()->where('id', $item['id'])->first();

                $salesDetails = new SalesDetails();
                $salesDetails->product_attribute_id = $item['id'];
                $salesDetails->sales_id = $sales->id;
                $salesDetails->qty = $item['qty'];
                $salesDetails->product_id = $item['product_id'];
                $salesDetails->sales_rate = $item['sales_price'];
                $salesDetails->discount = $item['discount'];
                $salesDetails->total = $item['total'];
                $salesDetails->created_time = $sales->created_time;
                $salesDetails->created_date = $sales->created_date;
                $salesDetails->current_unit_cost = $productAttribute->unit_cost;
                $salesDetails->save();


                $productAttribute->current_stock = intval($productAttribute->current_stock) - intval($item['qty']);
                $productAttribute->sales_rate = $item['sales_price'];


                $productAttribute->save();




                /* <- Product log send ->*/
                $curl = curl_init();
                $url = url('/api/log/product?product_attribute_id=' . $productAttribute->id
                    . '&type=3&qty=' . $item['qty'] . '&ref_id=' . $salesDetails->id);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_TIMEOUT, 3);
                curl_exec($curl);
                curl_close($curl);
            }

            DB::commit();
            return $this->respondWithSuccess('Successfully created Sales', $sales);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->respondWithError('error', $th->getMessage());
        }
    }

    public function edit(Request $request, $id)
    {

        if ($request->method() == 'PUT') {
            DB::beginTransaction();
            try {

                $sales = Sales::find($request->sales_id);
                if ($sales) {


                    $sales->company_id = Auth::user()->company_id;
                    $sales->customer_id = $request['customer_id'];
                    $sales->invoice_date = $request['invoice_date'];
                    $sales->total_amount = $request['total_amount'];
                    $sales->sub_amount = $request['sub_amount'];
                    $sales->paid_amount = $request['paid_amount'];
                    $sales->grand_total = $request['grand_total_amount'];
                    $sales->due_amount = floatval($request['total_amount']) - floatval($request['paid_amount']);
                    $sales->note = $request['note'];
                    $sales->discount = 0;
                    $sales->created_by = Auth::user()->id;
                    $sales->created_time = date('H:i:s');
                    $sales->created_date = date('Y-m-d');
                    $sales->save();


                    /* <- Sales Payment ->*/
                    $salesPayment = new SalesPayment();
                    $salesPayment->sales_id = $sales->id;
                    $salesPayment->transaction_type_id = $request['transaction_type_id'];
                    $salesPayment->amount = $sales->paid_amount;
                    $salesPayment->receipt_no = salesPaymentReceiptNo();
                    $salesPayment->customer_id = $sales->customer_id;
                    $salesPayment->discount = $sales->discount;
                    $salesPayment->created_date = $sales->created_date;
                    $salesPayment->added_by = Auth::user()->id;
                    $salesPayment->company_id = Auth::user()->company_id;
                    $salesPayment->save();


                    /* <- Sales Payment log send ->*/
                    paymentLogSend($salesPayment->transaction_type_id, 3, $salesPayment->amount, $salesPayment->id);
                    $productCustomizations =  $request['productCustomizations'];

                    foreach ($productCustomizations as $item) {

                        $productAttribute  = ProductAttribute::select()->where('id', $item['product_attribute_id'])->first();

                        $salesDetails = SalesDetails::find($item['id']);
                        if ($salesDetails) {
                            $beforeQty = $salesDetails->qty;
                        } else {
                            $salesDetails = new SalesDetails();
                            $beforeQty = 0;
                        }
                        $salesDetails->product_attribute_id = $item['product_attribute_id'];
                        $salesDetails->sales_id = $sales->id;
                        $salesDetails->qty = $item['qty'];
                        $salesDetails->product_id = $item['product_id'];
                        $salesDetails->sales_rate = $item['sales_rate'];
                        $salesDetails->discount = $item['discount'];
                        $salesDetails->current_unit_cost = $productAttribute->unit_cost;
                        $salesDetails->total = $item['total'];
                        $salesDetails->created_time = $sales->created_time;
                        $salesDetails->created_date = $sales->created_date;
                        $salesDetails->save();
                        $productAttribute->current_stock = intval($productAttribute->current_stock) +  intval($beforeQty) - intval($salesDetails->qty);
                        $productAttribute->sales_rate = $item['sales_rate'];
                        $productAttribute->save();
                        productLogSend($productAttribute->id, 3, $salesDetails->qty, $salesDetails->id);
                    }

                    DB::commit();
                    return $this->respondWithSuccess('Successfully updated Sales', $sales);
                }
            } catch (\Throwable $th) {
                DB::rollBack();
                return $this->respondWithError('error', $th->getMessage());
            }
        }

        $customers = Customer::select()->where('company_id', Auth::user()->company_id)->get();
        $transactionTypes = TransactionType::select()->where('company_id', Auth::user()->company_id)->get();
        return view('sales.edit', compact('customers','transactionTypes'));
    }

    public function invoice(Request $request, $id)
    {

        if ($request->fetch == "true") {
            $salesDetails = SalesDetails::select()->where('sales_id', $id)
                ->with('product', 'productAttribute')
                ->get();

            $sales = Sales::select()->where('id', $id)->with('company', 'customer', 'createdBy')->first();
            $salesPayment = SalesPayment::select()->where('sales_id', $sales->id)->with('transactionType')->first();
            $data = ['salesDetails' => $salesDetails, 'sales' => $sales, 'salesPayment' => $salesPayment];
            return $this->respondWithSuccess('Successfully fetch sales', $data);
        } else {
            return view('sales.invoice');
        }
    }

    public function getSalesCode($company_id)
    {
        $sales = Sales::where('company_id', $company_id)->orderBy('id', 'desc')->first();

        if ($sales && $sales->code) {
            $last__code = intval(explode("-", $sales->code)[1]);
            $last__code++;
            $code = 'INV-' . str_pad($last__code, 6, '0', STR_PAD_LEFT);
        } else {
            $code = 'INV-000001';
        }
        return $code;
    }

    public function paymentList(Request $request)
    {

        if ($request->fetch == "1") {
            $query = SalesPayment::where('company_id', Auth::user()->company_id)
                ->with('customer')->orderBy('created_at', 'desc')->get();
            return DataTables::of($query)->toJson();
        }
        return view('sales.payment-list');
    }

    public function dueCollection(Request $request)
    {
        if ($request->fetch == "1") {
            $query = DB::table('customers')
                ->where('company_id', Auth::user()->company_id)
                ->get()
                ->filter(function ($customer) {
                    $has_sales = DB::table('sales')
                        ->where('customer_id', $customer->id)
                        ->exists();
                    return $has_sales;
                })
                ->map(function ($customer) {
                    $total_amount = DB::table('sales')
                        ->where('customer_id', $customer->id)
                        ->sum('total_amount');

                    $total_pay_amount = DB::table('sales_payments')
                        ->where('customer_id', $customer->id)
                        ->sum('amount');

                    $customer->due_amount = floatval($total_amount) - floatval($total_pay_amount);
                    return $customer;
                })->filter(function ($customer) {
                    $customer = $customer->due_amount > 0;
                    return $customer;
                });
            return DataTables::of($query)->toJson();
        }
        return view('sales.due-collection');
    }

    // Fetches the
    public function fetchInvoice(Request $request)
    {

        if ($request->type == 'sales-return') {
            $sales = Sales::select()->where('id', $request->sales_id)->first();
            $salesDetails = SalesDetails::select()->where('sales_id', $request->sales_id)->with('productAttribute')->get();
            $data = [
                'sales' => $sales,
                'salesDetails' => $salesDetails,
            ];
            return $this->respondWithSuccess('Successfully fetch return sales data', $data);
        }


        if ($request->type == 'customer') {
            $total_amount = DB::table('sales')
                ->where('invoice_date', $request->date)
                ->where('customer_id', $request->customer_id)
                ->sum('total_amount');
            $total_pay_amount = DB::table('sales_payments')
                ->where('customer_id', $request->customer_id)
                ->where('created_date', $request->date)
                ->sum('amount');
            $due_amount = floatval($total_amount) - floatval($total_pay_amount);
            return $this->respondWithSuccess('Successfully fetch Sales invoice', $due_amount);
        }

        if ($request->date) {
            $sales = Sales::where('invoice_date', $request->date)
                ->where('due_amount', '!=', 0)
                ->orderBy('id', 'desc')
                ->with('customer')
                ->get();
        } else if ($request->sales_id) {
            $sales = Sales::where('id', $request->sales_id)->first();
        }


        if ($request->customer_id && $request->date) {
            $sales = Sales::where('invoice_date', $request->date)
                ->where('customer_id', $request->customer_id)
                ->where('due_amount', '!=', 0)
                ->get();
        }

        if ($sales) {
            return $this->respondWithSuccess('Successfully fetch sales invoice', $sales);
        } else {
            return $this->respondWithError('Not found');
        }
    }

    // delete
    public function delete(Request $request, $id)
    {
        try {

            if ($request->type == 'sales_details') {
                $salesDetails = SalesDetails::find($id);
                $salesDetails->save();
                return $this->respondWithSuccess('Sales Details deleted successfully', $salesDetails);
            }

            $sales = Sales::find($id);
            $sales->status = 0;
            $sales->save();
            return $this->respondWithSuccess('sales deleted successfully', $sales);
        } catch (\Throwable $th) {
            return $this->respondWithError('error', $th->getMessage());
        }
    }
}
