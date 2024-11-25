<?php

namespace App\Http\Controllers;

use App\Models\ProductAttribute;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnDetails;
use App\Models\PurchaseReturnPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PurchaseReturnController extends Controller
{


    public function __construct()
    {
        $this->checkAuth();
    }

    public function index(Request $request)
    {
        if ($request->type == 'fetch' && request()->ajax()) {
            $query = PurchaseReturn::where('company_id', Auth::user()->company_id)
                ->with('supplier')
                ->orderBy('created_at', 'desc')
                ->get();
            return DataTables::of($query)->toJson();
        }

        return view('purchase.return.list');
    }

    public function fetch($id)
    {
        $purchaseReturn = PurchaseReturn::where('company_id', Auth::user()->company_id)
            ->where('id', $id)
            ->with('supplier')
            ->orderBy('created_at', 'desc')
            ->first();
        $purchaseReturnDetails = PurchaseReturnDetails::select()
            ->where('purchase_returns_id', $id)
            ->with('productAttribute', 'productAttribute.product')
            ->get();
        $data = [
            'purchaseReturn' => $purchaseReturn,
            'purchaseReturnDetails' => $purchaseReturnDetails
        ];
        return $this->respondWithSuccess('Successfully fetched purchase return', $data);
    }



    //
    public function create(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('purchase.return.create');
        }


        DB::beginTransaction();
        try {

            $purchase = Purchase::find($request->purchase_id);
            $purchaseReturn = new PurchaseReturn();
            $purchaseReturn->company_id = $purchase->company_id;
            $purchaseReturn->supplier_id = $purchase->supplier_id;
            $purchaseReturn->purchase_id = $request->purchase_id;
            $purchaseReturn->invoice_date = $purchase->invoice_date;
            $purchaseReturn->total_amount = $request->total_amount;
            $purchaseReturn->return_amount = $request->return_amount;
            $purchaseReturn->code = getPurchaseReturnCode();
            $purchaseReturn->due_amount = $request->due_amount;
            $purchaseReturn->note = $request->note;
            $purchaseReturn->created_by = Auth::user()->id;
            $purchaseReturn->created_time = date('H:i:s');
            $purchaseReturn->created_date = date('Y-m-d');
            $purchaseReturn->save();

            foreach ($request->product_details as $item) {
                $purchaseReturnDetails = new PurchaseReturnDetails();
                $purchaseReturnDetails->purchase_details_id = $item['id'];
                $purchaseReturnDetails->purchase_returns_id = $purchaseReturn->id;
                $purchaseReturnDetails->product_attribute_id = $item['product_attribute_id'];
                $purchaseReturnDetails->purchase_rate = $item['purchase_rate'];
                $purchaseReturnDetails->return_qty = $item['return_qty'];
                $purchaseReturnDetails->discount = $item['discount'];
                $purchaseReturnDetails->total = $item['total'];
                $purchaseReturnDetails->created_time = date('H:i:s');
                $purchaseReturnDetails->created_date = date('Y-m-d');
                $purchaseReturnDetails->save();

                // subtruct current stock items
                $find_product_attribute = ProductAttribute::find($purchaseReturnDetails->product_attribute_id);
                $find_product_attribute->current_stock = intval($find_product_attribute->current_stock) - intval($purchaseReturnDetails->return_qty);
                $find_product_attribute->save();
            }

            // purchase return payments
            $purchaseReturnPayment = new PurchaseReturnPayment();
            $purchaseReturnPayment->purchase_return_id = $purchaseReturn->id;
            $purchaseReturnPayment->transaction_type_id = $request->transaction_type_id;
            $purchaseReturnPayment->company_id = $purchaseReturn->company_id;
            $purchaseReturnPayment->amount = $purchaseReturn->return_amount;
            $purchaseReturnPayment->receipt_no = purchasePaymentReturnReceiptNo();
            $purchaseReturnPayment->supplier_id = $purchaseReturn->supplier_id;
            $purchaseReturnPayment->added_by = Auth::user()->id;
            $purchaseReturnPayment->created_date = date('Y-m-d');
            $purchaseReturnPayment->save();

            /* <- Purchase Payment log send ->*/
            $curl = curl_init();
            $url = url('/api/log/transection?transaction_type_id=' . $request->transaction_type_id
                . '&type=2&amount=' . $purchaseReturnPayment->amount . '&ref_id=' . $purchaseReturnPayment->id);
            // Set cURL options
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response as a string instead of outputting it
            curl_setopt($curl, CURLOPT_TIMEOUT, 1); // Set a timeout for the request (in seconds)
            curl_exec($curl);
            curl_close($curl);


            DB::commit();
            return $this->respondWithSuccess('Successful create purchase return', $purchaseReturn);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->respondWithError('Somethings went wrong.!!', $th->getMessage());
        }
    }

    public function invoice(Request $request, $id)
    {

        if ($request->fetch == "true") {
            $purchaseReturnDetails = PurchaseReturnDetails::select()->where('purchase_returns_id', $id)
                ->with('productAttribute', 'productAttribute.product')
                ->get();

            $purchaseReturn = PurchaseReturn::select()->where('id', $id)->with('company', 'supplier', 'createdBy')->first();

            $purchaseReturnPayment = PurchaseReturnPayment::select()->where('purchase_return_id', $purchaseReturn->id)->with('transactionType')->first();
            $data = ['purchaseReturnDetails' => $purchaseReturnDetails, 'purchaseReturn' => $purchaseReturn, 'purchaseReturnPayment' => $purchaseReturnPayment];
            return $this->respondWithSuccess('Successfully fetch Purchases', $data);
        } else {
            return view('purchase.return.invoice');
        }
    }



    public function edit(Request $request, $id)
    {

        if ($request->method() == 'PUT') {
            DB::beginTransaction();
            try {


                $purchaseReturn = PurchaseReturn::find($request->purchase_return_id);
                if ($purchaseReturn) {


                    $purchaseReturn->company_id = Auth::user()->company_id;
                    $purchaseReturn->supplier_id = $request->supplier_id;
                    $purchaseReturn->invoice_date = $request->invoice_date;
                    $purchaseReturn->total_amount = $request->total_amount;
                    $purchaseReturn->return_amount = $request->return_amount;
                    $purchaseReturn->due_amount = floatval($request->total_amount) - floatval($request->return_amount);
                    $purchaseReturn->note = $request->note;
                    $purchaseReturn->created_by = Auth::user()->id;
                    $purchaseReturn->created_time = date('H:i:s');
                    $purchaseReturn->created_date = date('Y-m-d');
                    $purchaseReturn->save();




                    /* <- Purchase Payment ->*/
                    // purchase return payments
                    $purchaseReturnPayment = new PurchaseReturnPayment();
                    $purchaseReturnPayment->purchase_return_id = $purchaseReturn->id;
                    $purchaseReturnPayment->transaction_type_id = $request->transaction_type_id;
                    $purchaseReturnPayment->company_id = $purchaseReturn->company_id;
                    $purchaseReturnPayment->amount = $purchaseReturn->return_amount;
                    $purchaseReturnPayment->receipt_no = purchasePaymentReturnReceiptNo();
                    $purchaseReturnPayment->supplier_id = $purchaseReturn->supplier_id;
                    $purchaseReturnPayment->added_by = Auth::user()->id;
                    $purchaseReturnPayment->created_date = date('Y-m-d');
                    $purchaseReturnPayment->save();


                    /* <- Purchase Payment log send ->*/
                    $curl = curl_init();
                    $url = url('/api/log/transection?transaction_type_id=' . $purchaseReturn->transaction_type_id
                        . '&type=2&amount=' . $purchaseReturn->amount . '&ref_id=' . $purchaseReturn->id);
                    // Set cURL options
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response as a string instead of outputting it
                    curl_setopt($curl, CURLOPT_TIMEOUT, 3); // Set a timeout for the request (in seconds)
                    curl_exec($curl);
                    curl_close($curl);

                    $productCustomizations =  $request->productCustomizations;



                    foreach ($productCustomizations as $item) {
                        $purchaseDetails = PurchaseReturnDetails::find($item['id']);
                        $beforeQty = $purchaseDetails->return_qty;
                        $purchaseDetails->product_attribute_id = $item['product_attribute_id'];
                        $purchaseDetails->return_qty = $item['return_qty'];
                        $purchaseDetails->purchase_rate = $item['purchase_rate'];
                        $purchaseDetails->discount = $item['discount'];
                        $purchaseDetails->total = $item['total'];
                        $purchaseDetails->save();



                        $productAttribute  = ProductAttribute::select()->where('id', $item['product_attribute_id'])->first();
                        $productAttribute->current_stock = intval($productAttribute->current_stock) - intval($item['return_qty']) + intval($beforeQty);
                        $productAttribute->last_purchase = $item['purchase_rate'];

                        $productAttribute->unit_cost = ((intval($productAttribute->current_stock) * floatval($productAttribute->last_purchase)) +
                            (floatval($item['purchase_rate']) * intval($item['return_qty']))) / (intval($productAttribute->current_stock) + intval($item['return_qty']));
                        $productAttribute->save();



                        /* <- Product log send ->*/
                        $curl = curl_init();
                        $url = url('/api/log/product?product_attribute_id=' . $productAttribute->id
                            . '&type=1&qty=' . $item['return_qty'] . '&ref_id=' . $purchaseDetails->id);
                        curl_setopt($curl, CURLOPT_URL, $url);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_TIMEOUT, 3);
                        curl_exec($curl);
                        curl_close($curl);
                    }

                    DB::commit();
                    return $this->respondWithSuccess('Successfully updated Purchases', $purchaseReturn);
                }
            } catch (\Throwable $th) {
                DB::rollBack();
                return $this->respondWithError('error', $th->getMessage());
            }
        }

        return view('purchase.return.edit');
    }
}
