<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Models\Sales;
use App\Models\TransactionType;
use App\Models\SalesReturn;
use App\Models\SalesReturnDetails;
use App\Models\SalesReturnPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SalesReturnController extends Controller
{
    public function __construct()
    {
        $this->checkAuth();
    }

    public function index(Request $request)
    {


        if ($request->type == 'fetch' && request()->ajax()) {

            $query = SalesReturn::where('company_id', Auth::user()->company_id)
                ->with('customer')
                ->orderBy('created_at', 'desc')
                ->get();
            return DataTables::of($query)->addIndexColumn()->toJson();
        }

        return view('sales.return.list');
    }

    public function fetch($id)
    {
        $salesReturn = SalesReturn::where('company_id', Auth::user()->company_id)
            ->where('id', $id)
            ->with('customer')
            ->orderBy('created_at', 'desc')
            ->first();
        $salesReturnDetails = SalesReturnDetails::select()
            ->where('sales_returns_id', $id)
            ->with('productAttribute', 'productAttribute.product')
            ->get();
        $data = [
            'salesReturn' => $salesReturn,
            'salesReturnDetails' => $salesReturnDetails
        ];
        return $this->respondWithSuccess('Successfully fetched Sales return', $data);
    }




    //
    public function create(Request $request)
    {
        if ($request->method() == 'GET') {
            $date = date('Y-m-d');
            $transactionTypes = TransactionType::select()->where('company_id', Auth::user()->company_id)->get();

            return view('sales.return.create', compact('date', 'transactionTypes'));
        }


        DB::beginTransaction();
        try {

            $sales = Sales::find($request->sales_id);
            $salesReturn = new SalesReturn();
            $salesReturn->company_id = $sales->company_id;
            $salesReturn->customer_id = $sales->customer_id;
            $salesReturn->sales_id = $request->sales_id;
            $salesReturn->invoice_date = $sales->invoice_date;
            $salesReturn->total_amount = $request->total_amount;
            $salesReturn->return_amount = $request->return_amount;
            $salesReturn->code = getSalesReturnCode();
            $salesReturn->due_amount = $request->due_amount;
            $salesReturn->note = $request->note;
            $salesReturn->created_by = Auth::user()->id;
            $salesReturn->created_time = date('H:i:s');
            $salesReturn->created_date = date('Y-m-d');
            $salesReturn->save();



            foreach ($request->product_details as $item) {



                $salesReturnDetails = new SalesReturnDetails();
                $find_product_attribute = ProductAttribute::find($item['product_attribute_id']);
                $current_stock = intval($find_product_attribute->current_stock) + $item['return_qty'];

                $salesReturnDetails->sales_details_id = $item['id'];
                $salesReturnDetails->Sales_returns_id = $salesReturn->id;
                $salesReturnDetails->product_attribute_id = $item['product_attribute_id'];
                $salesReturnDetails->sales_rate = $item['sales_rate'];
                $salesReturnDetails->return_qty = $item['return_qty'];
                $salesReturnDetails->discount = $item['discount'];
                $salesReturnDetails->total = $item['total'];
                $salesReturnDetails->created_time = date('H:i:s');
                $salesReturnDetails->created_date = date('Y-m-d');
                $salesReturnDetails->save();

                // Subtruct current stock items
                $find_product_attribute->current_stock =  $current_stock;
                $find_product_attribute->save();
            }



            // Sales return payments
            $salesReturnPayment = new SalesReturnPayment();
            $salesReturnPayment->sales_return_id = $salesReturn->id;
            $salesReturnPayment->transaction_type_id = $request->transaction_type_id;
            $salesReturnPayment->company_id = $salesReturn->company_id;
            $salesReturnPayment->amount = $salesReturn->return_amount;
            $salesReturnPayment->receipt_no = salesPaymentReturnReceiptNo();
            $salesReturnPayment->customer_id = $salesReturn->customer_id;
            $salesReturnPayment->added_by = Auth::user()->id;
            $salesReturnPayment->created_date = date('Y-m-d');
            $salesReturnPayment->save();

            /* <- Sales Payment log send ->*/
            paymentLogSend($request->transaction_type_id, 4, $salesReturnPayment->amount, $salesReturnPayment->id);

            DB::commit();
            return $this->respondWithSuccess('Successful created sales return', $salesReturn);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->respondWithError('Somethings went wrong.!!', $th->getMessage());
        }
    }

    public function invoice(Request $request, $id)
    {


        $print_date = date('Y-m-d');
        $invoice_name = 'Sales Return Invoice';
        $itemDetails = SalesReturnDetails::select()->where('Sales_returns_id', $id)
                ->with('productAttribute', 'productAttribute.product')
                ->get();
        $item  = SalesReturn::select()->where('id', $id)->with('company', 'customer', 'createdBy')->first();
        $payment = SalesReturnPayment::select()->where('Sales_return_id', $item->id)->with('transactionType')->first();
        $invoice_name = 'Invoice';
        $back_url = "/sales/return/list";

        return view('sales.return.invoice', compact('print_date', 'item', 'itemDetails', 'back_url','payment', 'invoice_name'));
    }



    public function edit(Request $request, $id)
    {

        if ($request->method() == 'PUT') {
            DB::beginTransaction();
            try {


                $salesReturn = SalesReturn::find($request->sales_return_id);
                if ($salesReturn) {


                    $salesReturn->company_id = Auth::user()->company_id;
                    $salesReturn->customer_id = $request->customer_id;
                    $salesReturn->invoice_date = $request->invoice_date;
                    $salesReturn->total_amount = $request->total_amount;
                    $salesReturn->return_amount = $request->return_amount;
                    $salesReturn->due_amount = floatval($request->total_amount) - floatval($request->return_amount);
                    $salesReturn->note = $request->note;
                    $salesReturn->created_by = Auth::user()->id;
                    $salesReturn->created_time = date('H:i:s');
                    $salesReturn->created_date = date('Y-m-d');
                    $salesReturn->save();




                    /* <- Sales Payment ->*/
                    // Sales return payments
                    $salesReturnPayment = new SalesReturnPayment();
                    $salesReturnPayment->sales_return_id = $salesReturn->id;
                    $salesReturnPayment->transaction_type_id = $request->transaction_type_id;
                    $salesReturnPayment->company_id = $salesReturn->company_id;
                    $salesReturnPayment->amount = $salesReturn->return_amount;
                    $salesReturnPayment->receipt_no = SalesPaymentReturnReceiptNo();
                    $salesReturnPayment->customer_id = $salesReturn->customer_id;
                    $salesReturnPayment->added_by = Auth::user()->id;
                    $salesReturnPayment->created_date = date('Y-m-d');
                    $salesReturnPayment->save();


                    /* <- Sales Payment log send ->*/
                    paymentLogSend($salesReturn->transaction_type_id, 4, $salesReturn->amount, $salesReturn->id);

                    $productCustomizations =  $request->productCustomizations;



                    foreach ($productCustomizations as $item) {
                        $salesDetails = SalesReturnDetails::find($item['id']);
                        $beforeQty = $salesDetails->return_qty;
                        $salesDetails->product_attribute_id = $item['product_attribute_id'];
                        $salesDetails->return_qty = $item['return_qty'];
                        $salesDetails->sales_rate = $item['sales_rate'];
                        $salesDetails->discount = $item['discount'];
                        $salesDetails->total = $item['total'];
                        $salesDetails->save();



                        $productAttribute  = ProductAttribute::select()->where('id', $item['product_attribute_id'])->first();
                        $productAttribute->current_stock = intval($productAttribute->current_stock) - intval($item['return_qty']) + intval($beforeQty);


                        $productAttribute->sales_rate = $item['sales_rate'];
                        $productAttribute->save();



                        /* <- Product log send ->*/
                        $curl = curl_init();
                        $url = url('/api/log/product?product_attribute_id=' . $productAttribute->id
                            . '&type=4&qty=' . $item['return_qty'] . '&ref_id=' . $salesDetails->id);
                        curl_setopt($curl, CURLOPT_URL, $url);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_TIMEOUT, 3);
                        curl_exec($curl);
                        curl_close($curl);
                    }

                    DB::commit();
                    return $this->respondWithSuccess('Successfully updated Saless', $salesReturn);
                }
            } catch (\Throwable $th) {
                DB::rollBack();
                return $this->respondWithError('error', $th->getMessage());
            }
        }

        return view('sales.return.edit');
    }
}
