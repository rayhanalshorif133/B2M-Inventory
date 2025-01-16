<?php

namespace App\Http\Controllers;

use App\Models\ProductAttribute;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\PurchasePayment;
use App\Models\TransactionType;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class PurchaseController extends Controller
{


    public function __construct()
    {
        $this->checkAuth();
    }


    public function index(Request $request)
    {
        if ($request->type == 'fetch' && request()->ajax()) {
            $query = Purchase::where('company_id', Auth::user()->company_id)
                // ->where('status', '1')
                ->with('supplier')->orderBy('created_at', 'desc')
                ->get();
            return DataTables::of($query)->toJson();
        }
        return view('purchase.index');
    }

    public function fetch($id)
    {
        $purchase = Purchase::where('company_id', Auth::user()->company_id)
            ->where('id', $id)
            ->with('supplier')
            ->orderBy('created_at', 'desc')
            ->first();
        $purchase->payment = PurchasePayment::select()->where('company_id', Auth::user()->company_id)
            ->where('purchases_id', $id)
            ->first();
        $purchaseDetails = PurchaseDetails::select()
            ->where('purchases_id', $id)
            ->with('product', 'productAttribute')
            ->get();
        $data = [
            'purchase' => $purchase,
            'purchaseDetails' => $purchaseDetails
        ];
        return $this->respondWithSuccess('Successfully fetched purchase', $data);
    }

    public function create(Request $request)
    {
        $company_id = $request->session()->get('company_id');
        if ($request->method() == 'GET') {
            $suppliers = Supplier::select()->where('company_id', $company_id)->get();
            $transactionTypes = TransactionType::select()->where('company_id', $company_id)->get();
            $purchaseCode = $this->getPurchaseCode($company_id);
            return view('purchase.create', compact('suppliers', 'transactionTypes', 'purchaseCode'));
        }

        DB::beginTransaction();
        try {


            $product_details = $request->product_details;
            $company_id = $request->session()->get('company_id');
            $purchase_order = $request->purchase_order;

            $purchase = new Purchase();
            $purchase->company_id = $company_id;
            $purchase->supplier_id = $purchase_order['supplier_id'];
            $purchase->code =  $purchase_order['voucher_number'];
            $purchase->invoice_date = $purchase_order['invoice_date'];
            $purchase->total_amount = $purchase_order['total_amount'];
            $purchase->sub_amount = 0;
            $purchase->paid_amount = $purchase_order['paid_amount'];
            $purchase->grand_total = $purchase_order['grand_total_amount'];
            $purchase->due_amount = floatval($purchase_order['total_amount']) - floatval($purchase_order['paid_amount']);
            $purchase->note = $purchase_order['supplier_note'];
            $purchase->discount = $purchase_order['total_discount'];
            $purchase->created_by = Auth::user()->id;
            $purchase->created_time = date('H:i:s');
            $purchase->created_date = date('Y-m-d');
            $purchase->save();



            /* <- Purchase Payment ->*/
            $purchasePayment = new PurchasePayment();
            $purchasePayment->purchases_id = $purchase->id;
            $purchasePayment->transaction_type_id = $purchase_order['transaction_type'];
            $purchasePayment->amount = $purchase->paid_amount;
            $purchasePayment->receipt_no = purchasePaymentReceiptNo();
            $purchasePayment->supplier_id = $purchase->supplier_id;
            $purchasePayment->discount = $purchase->discount;
            $purchasePayment->created_date = $purchase->created_date;
            $purchasePayment->added_by = Auth::user()->id;
            $purchasePayment->company_id = $company_id;
            $purchasePayment->save();


            /* <- Purchase Payment log send ->*/
            paymentLogSend($purchasePayment->transaction_type_id, 1, $purchasePayment->amount, $purchasePayment->id);



            foreach ($product_details as $item) {

                $productAttribute  = ProductAttribute::select()->where('id', $item['product_attribute_id'])->first();

                $purchaseDetails = new PurchaseDetails();
                $purchaseDetails->product_attribute_id = $productAttribute->id;
                $purchaseDetails->purchases_id = $purchase->id;
                $purchaseDetails->qty = $item['qty'];
                $purchaseDetails->product_id = $item['product_id'];
                $purchaseDetails->purchase_rate = $item['last_purchase'];
                $purchaseDetails->discount = $item['discount'];
                $purchaseDetails->total = $item['total'];
                $purchaseDetails->created_time = $purchase->created_time;
                $purchaseDetails->created_date = $purchase->created_date;
                $purchaseDetails->save();



                $productAttribute->current_stock = intval($productAttribute->current_stock) + intval($item['qty']);
                $productAttribute->last_purchase = $item['last_purchase'];

                $productAttribute->unit_cost = ((intval($productAttribute->current_stock) * floatval($productAttribute->last_purchase)) +
                    (floatval($item['last_purchase']) * intval($item['qty']))) / (intval($productAttribute->current_stock) + intval($item['qty']));
                $productAttribute->save();
                // Sent Product Log ->
                productLogSend($productAttribute->id, 1, $item['qty'], $purchaseDetails->id);
            }


            DB::commit();
            return redirect()->route('purchase.invoice', $purchase->id)->with('success', 'Successfully created purchases');
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



                $product_details = $request->product_details;


                $company_id = $request->session()->get('company_id');
                $purchase_order = $request->purchase_order;

                $purchase = Purchase::find($id);
                if ($purchase) {
                    // $purchaseDetails = PurchaseDetails::where('purchases_id', $purchase->id)->delete();

                    $purchase->company_id = $company_id;
                    $purchase->supplier_id = $purchase_order['supplier_id'];
                    $purchase->invoice_date = $purchase_order['invoice_date'];
                    $purchase->code = $purchase_order['voucher_number'];
                    $purchase->total_amount = $purchase_order['total_amount'];
                    $purchase->sub_amount = $request['sub_amount'] ? $request['sub_amount'] : 0;
                    $purchase->paid_amount = $purchase_order['paid_amount'];
                    $purchase->grand_total = $purchase_order['grand_total_amount'];
                    $purchase->due_amount = floatval($purchase_order['total_amount']) - floatval($purchase_order['paid_amount']);
                    $purchase->status = 1;
                    $purchase->note = $purchase_order['supplier_note'];
                    $purchase->discount = $purchase_order['total_discount'];
                    $purchase->created_time = date('H:i:s');
                    $purchase->created_date = date('Y-m-d');
                    $purchase->created_by = Auth::user()->id;
                    $purchase->save();


                     /* <- Purchase Payment ->*/
                    $purchasePayment = PurchasePayment::select()->where('purchases_id', $id)->first();
                    $purchasePayment->transaction_type_id = $purchase_order['transaction_type'];
                    $purchasePayment->amount = $purchase->paid_amount;
                    $purchasePayment->supplier_id = $purchase->supplier_id;
                    $purchasePayment->discount = $purchase->discount;
                    $purchasePayment->created_date = $purchase->created_date;
                    $purchasePayment->added_by = Auth::user()->id;
                    $purchasePayment->company_id = $company_id;
                    $purchasePayment->save();

                    /* <- Purchase Payment log send ->*/
                    paymentLogSend($purchasePayment->transaction_type_id, 1, $purchasePayment->amount, $purchasePayment->id);

                    foreach ($product_details as $item) {
                        $productAttribute  = ProductAttribute::select()->where('id', $item['product_attribute_id'])->first();

                        $purchaseDetails = PurchaseDetails::find($item['id']);

                        if ($purchaseDetails) {
                            $beforeQty = $purchaseDetails->qty;
                        } else {
                            $purchaseDetails = new PurchaseDetails();
                            $beforeQty = 0;
                        }

                        $purchaseDetails->product_attribute_id = $item['product_attribute_id'];
                        $purchaseDetails->purchases_id = $purchase->id;
                        $purchaseDetails->qty = $item['qty'];
                        $purchaseDetails->product_id = $item['product_id'];
                        $purchaseDetails->purchase_rate = $item['purchase_rate'];
                        $purchaseDetails->discount = $item['discount'];
                        $purchaseDetails->total = $item['total'];
                        $purchaseDetails->created_time = $purchase->created_time;
                        $purchaseDetails->created_date = $purchase->created_date;
                        $purchaseDetails->save();


                        $productAttribute->current_stock = intval($productAttribute->current_stock) + intval($item['qty']) - intval($beforeQty);
                        $productAttribute->last_purchase = $item['purchase_rate'];

                        $productAttribute->unit_cost = ((intval($productAttribute->current_stock) * floatval($productAttribute->last_purchase)) +
                            (floatval($item['purchase_rate']) * intval($item['qty']))) / (intval($productAttribute->current_stock) + intval($item['qty']));
                        $productAttribute->save();

                        /* <- Product log send ->*/

                        productLogSend($productAttribute->id, 1, $item['qty'], $purchaseDetails->id);
                    }

                    DB::commit();
                    return redirect()->route('purchase.invoice', ['id' => $purchase->id]);
                }
            } catch (\Throwable $th) {
                DB::rollBack();
                dd($th->getMessage());
                return $this->respondWithError('error', $th->getMessage());
            }
        }


        $purchase = Purchase::find($id);
        $purchasePayments = PurchasePayment::select()->where('purchases_id', $id)->first();
        $purchaseDetails = PurchaseDetails::select()->where('purchases_id', $id)
            ->with('product', 'productAttribute')
            ->get();
        $company_id = $request->session()->get('company_id');
        $suppliers = Supplier::select()->where('company_id', $company_id)->get();
        $transactionTypes = TransactionType::select()->where('company_id', $company_id)->get();
        $purchase_code = $purchase->code;
        return view('purchase.edit', compact('purchase', 'suppliers', 'purchaseDetails', 'purchasePayments', 'transactionTypes', 'purchase_code'));
    }




    public function invoice(Request $request, $id)
    {

        if ($request->fetch == "true") {
            $purchaseDetails = PurchaseDetails::select()->where('purchases_id', $id)
                ->with('product', 'productAttribute')
                ->get();

            $purchase = Purchase::select()->where('id', $id)->with('company', 'supplier', 'createdBy')->first();
            $purchasePayment = PurchasePayment::select()->where('purchases_id', $purchase->id)->with('transactionType')->first();
            $data = ['purchaseDetails' => $purchaseDetails, 'purchase' => $purchase, 'purchasePayment' => $purchasePayment];
            return $this->respondWithSuccess('Successfully fetch Purchases', $data);
        } else {
            return view('purchase.invoice');
        }
    }


    public function getPurchaseCode($company_id)
    {
        $purchase = Purchase::where('company_id', $company_id)->orderBy('id', 'desc')->first();

        if ($purchase && $purchase->code) {
            $last__code = intval(explode("-", $purchase->code)[1]);
            $last__code++;
            $code = 'PUR-' . str_pad($last__code, 6, '0', STR_PAD_LEFT);
        } else {
            $code = 'PUR-000001';
        }
        return $code;
    }


    public function paymentList(Request $request)
    {

        if ($request->fetch == "1") {
            $query = PurchasePayment::where('company_id', Auth::user()->company_id)
                ->with('supplier')->orderBy('created_at', 'desc')->get();
            return DataTables::of($query)->addIndexColumn()->toJson();
        }
        return view('purchase.payment-list');
    }

    public function dueCollection(Request $request)
    {
        if ($request->fetch == "1") {
            $query = DB::table('suppliers')
                ->where('company_id', Auth::user()->company_id)
                ->get()
                ->filter(function ($supplier) {
                    $has_purchases = DB::table('purchases')
                        ->where('supplier_id', $supplier->id)
                        ->exists();

                    return $has_purchases; // Keep only suppliers with purchases
                })
                ->map(function ($supplier) {
                    $total_amount = DB::table('purchases')
                        ->where('supplier_id', $supplier->id)
                        ->sum('total_amount'); // Total amount of purchases

                    $total_pay_amount = DB::table('purchase_payments')
                        ->where('supplier_id', $supplier->id)
                        ->sum('amount'); // Total payments made to the supplier

                    $supplier->due_amount = floatval($total_amount) - floatval($total_pay_amount);

                    return $supplier;
                })->filter(function ($supplier) {
                    return $supplier->due_amount > 0;
                });

            return DataTables::of($query)->addIndexColumn()->toJson();
        }

        $company_id = $request->session()->get('company_id');
        $transactionTypes = TransactionType::select()->where('company_id', $company_id)->get();
        return view('purchase.due-collection', compact('transactionTypes'));
    }



    // Fetches the
    public function fetchInvoice(Request $request)
    {

        if ($request->type == 'purchase-return') {
            $purchase = Purchase::select()->where('id', $request->purchase_id)->first();
            $purchaseDetails = PurchaseDetails::select()->where('purchases_id', $request->purchase_id)->with('productAttribute')->get();
            $data = [
                'purchase' => $purchase,
                'purchaseDetails' => $purchaseDetails,
            ];
            return $this->respondWithSuccess('Successfully fetch return purchases data', $data);
        }


        if ($request->type == 'supplier') {
            $total_amount = DB::table('purchases')
                ->where('invoice_date', $request->date)
                ->where('supplier_id', $request->supplier_id)
                ->sum('total_amount');
            $total_pay_amount = DB::table('purchase_payments')
                ->where('supplier_id', $request->supplier_id)
                ->where('created_date', $request->date)
                ->sum('amount');
            $due_amount = floatval($total_amount) - floatval($total_pay_amount);
            return $this->respondWithSuccess('Successfully fetch Purchases invoice', $due_amount);
        }

        if ($request->date) {
            $purchases = Purchase::where('invoice_date', $request->date)
                ->where('due_amount', '!=', 0)
                ->orderBy('id', 'desc')
                ->with('supplier')
                ->get();
        } else if ($request->purchase_id) {
            $purchases = Purchase::where('id', $request->purchase_id)->first();
        }


        if ($request->supplier_id && $request->date) {
            $purchases = Purchase::where('invoice_date', $request->date)
                ->where('supplier_id', $request->supplier_id)
                ->where('due_amount', '!=', 0)
                ->get();
        }



        if ($purchases) {
            return $this->respondWithSuccess('Successfully fetch Purchases invoice', $purchases);
        } else {
            return $this->respondWithError('Not found');
        }
    }


    // delete
    public function delete(Request $request, $id)
    {
        try {

            if($request->type == 'details'){
                $purchaseDetail = PurchaseDetails::find($id);
                $purchaseDetail->delete();
                return $this->respondWithSuccess('Purchase Details deleted successfully', $purchaseDetail);
            }

            $purchase = Purchase::find($id);
            $purchase->status = 0;
            $purchase->save();
            return $this->respondWithSuccess('Purchases deleted successfully', $purchase);
        } catch (\Throwable $th) {
            return $this->respondWithError('error', $th->getMessage());
        }
    }
}
