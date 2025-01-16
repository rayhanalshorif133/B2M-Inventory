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
use Illuminate\Support\Facades\Session;
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
            $company_id = $request->session()->get('company_id');
            $query = Sales::where('company_id', $company_id)
                ->with('customer')->orderBy('created_at', 'desc')
                ->get();
            return DataTables::of($query)->addIndexColumn()->toJson();
        }
        return view('sales.index');
    }

    public function fetch($id)
    {

        $sales = Sales::where('company_id', Auth::user()->company_id)
            ->where('id', $id)
            ->with('customer')
            ->first();

        $sales->payment = SalesPayment::select()->where('company_id', Auth::user()->company_id)
            ->where('sales_id', $id)
            ->first();
        $salesDetails = SalesDetails::select()
            ->where('sales_id', $id)
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

            $company_id = $request->session()->get('company_id');
            $customers = Customer::select()->where('company_id', $company_id)->get();
            $transactionTypes = TransactionType::select()->where('company_id', $company_id)->get();
            $sales_code = $this->getSalesCode($company_id);
            return view('sales.create', compact('customers', 'transactionTypes', 'sales_code'));
        }





        DB::beginTransaction();
        try {


            $product_details = $request->product_details;



            $company_id = $request->session()->get('company_id');
            $sales_order = $request->sales_order;

            $sales = new Sales();
            $sales->company_id = $company_id;
            $sales->customer_id = $sales_order['customer_id'];
            $sales->code = $sales_order['voucher_number'];
            $sales->status = 1;
            $sales->invoice_date = $sales_order['invoice_date'];
            $sales->total_amount = $sales_order['total_amount'];
            $sales->sub_amount = 0;
            $sales->paid_amount = $sales_order['paid_amount'];
            $sales->grand_total = $sales_order['grand_total_amount'];
            $sales->due_amount = $sales_order['due_amount'];
            $sales->note = $sales_order['customer_note'];
            $sales->discount = $sales_order['total_discount'];
            $sales->created_by = Auth::user()->id;
            $sales->created_time = date('H:i:s');
            $sales->created_date = date('Y-m-d');
            $sales->save();


            /* <- Sales Payment ->*/
            $salesPayment = new SalesPayment();
            $salesPayment->sales_id = $sales->id;
            $salesPayment->transaction_type_id = $sales_order['transaction_type'];
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

            foreach ($product_details as $item) {
                $productAttribute  = ProductAttribute::select()->where('id', $item['product_attribute_id'])->first();

                $salesDetails = new SalesDetails();
                $salesDetails->product_attribute_id = $item['product_attribute_id'];
                $salesDetails->sales_id = $sales->id;


                $salesDetails->qty = $item['qty'];
                $salesDetails->product_id = $item['product_id'];
                $salesDetails->sales_rate = $item['sales_rate'];
                $salesDetails->discount = $item['discount'];
                $salesDetails->total = $item['total'];
                $salesDetails->created_time = $sales->created_time;
                $salesDetails->created_date = $sales->created_date;
                $salesDetails->current_unit_cost = $productAttribute->unit_cost;
                $salesDetails->save();


                $productAttribute->current_stock = intval($productAttribute->current_stock) - intval($item['qty']);
                $productAttribute->sales_rate = $item['sales_rate'];


                $productAttribute->save();
                /* <- Product log send ->*/
                productLogSend($productAttribute->id, 3, $item['qty'], $salesDetails->id);
            }

            DB::commit();
            return redirect()->route('type.invoice', ['type' => 'sales', 'id' => $sales->id]);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            return redirect()->route('sales.index')->with('error', $th->getMessage());
        }
    }

    public function edit(Request $request, $id)
    {

        if ($request->method() == 'PUT') {
            DB::beginTransaction();
            try {






                $product_details = $request->product_details;


                $company_id = $request->session()->get('company_id');
                $sales_order = $request->sales_order;

                $sales = Sales::find($id);
                $sales->company_id = $company_id;
                $sales->customer_id = $sales_order['customer_id'];
                $sales->code = $sales_order['voucher_number'];
                $sales->status = 1;
                $sales->invoice_date = $sales_order['invoice_date'];
                $sales->total_amount = $sales_order['total_amount'];
                $sales->sub_amount = 0;
                $sales->paid_amount = $sales_order['paid_amount'];
                $sales->grand_total = $sales_order['grand_total_amount'];
                $sales->due_amount = $sales_order['due_amount'];
                $sales->note = $sales_order['customer_note'];
                $sales->discount = $sales_order['total_discount'];
                $sales->created_time = date('H:i:s');
                $sales->created_date = date('Y-m-d');
                $sales->save();


                /* <- Sales Payment ->*/
                $salesPayment = SalesPayment::select()->where('sales_id', $id)->first();
                $salesPayment->transaction_type_id = $sales_order['transaction_type'];
                $salesPayment->amount = $sales->paid_amount;
                $salesPayment->customer_id = $sales->customer_id;
                $salesPayment->discount = $sales->discount;
                $salesPayment->created_date = $sales->created_date;
                $salesPayment->added_by = Auth::user()->id;
                $salesPayment->company_id = Auth::user()->company_id;
                $salesPayment->save();


                /* <- Sales Payment log send ->*/
                paymentLogSend($salesPayment->transaction_type_id, 3, $salesPayment->amount, $salesPayment->id);

                foreach ($product_details as $item) {
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
                    $salesDetails->total = $item['total'];
                    $salesDetails->created_time = $sales->created_time;
                    $salesDetails->created_date = $sales->created_date;
                    $salesDetails->current_unit_cost = $productAttribute->unit_cost;
                    $salesDetails->save();

                    $productAttribute->current_stock = intval($productAttribute->current_stock) +  intval($beforeQty) - intval($salesDetails->qty);
                    $productAttribute->sales_rate = $item['sales_rate'];
                    $productAttribute->save();
                    productLogSend($productAttribute->id, 3, $item['qty'], $salesDetails->id);
                }
                DB::commit();
                return redirect()->route('type.invoice', ['type' => 'sales', 'id' => $sales->id]);
            } catch (\Throwable $th) {
                DB::rollBack();
                return $this->respondWithError('error', $th->getMessage());
            }
        }


        $sales = Sales::find($id);
        $salesPayments = SalesPayment::select()->where('sales_id', $id)->first();
        $salesDetails = SalesDetails::select()->where('sales_id', $id)
            ->with('product', 'productAttribute')
            ->get();
        $company_id = $request->session()->get('company_id');
        $customers = Customer::select()->where('company_id', $company_id)->get();
        $transactionTypes = TransactionType::select()->where('company_id', $company_id)->get();
        $sales_code = $sales->code;
        return view('sales.edit', compact('sales', 'customers', 'salesDetails', 'salesPayments', 'transactionTypes', 'sales_code'));
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
        $company_id = $request->session()->get('company_id');

        if ($request->fetch == "1") {
            $query = SalesPayment::where('company_id', $company_id)
                ->with('customer')->orderBy('created_at', 'desc')->get();
            return DataTables::of($query)->toJson();
        }

        $transactionTypes = TransactionType::select()->where('company_id', $company_id)->get();
        return view('sales.payment.list', compact('transactionTypes'));
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
            return DataTables::of($query)->addIndexColumn()->toJson();
        }
        $transactionTypes = TransactionType::select()->where('company_id', Auth::user()->company_id)->get();
        return view('sales.due-collection', compact('transactionTypes'));
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
                $salesDetails->delete();
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
