<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use App\Models\Sales;
use App\Models\SalesPayment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function purchasePay(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('payment.purchases.index');
        }

        try {

            $purchasesId = "";
            $discount = "";

            if ($request->purchase_id) {
                $purchase = Purchase::find($request->purchase_id);
                $purchase->paid_amount = floatval($purchase->paid_amount) + floatval($request->payment_amount);
                $purchase->due_amount = floatval($purchase->due_amount) - floatval($request->payment_amount);
                $purchase->save();

                $purchasesId = $purchase->id;
                $discount = $purchase->discount;
            } else {
                $purchasesId = null;
                $discount = 0;
            }

            $purchasePayment = new PurchasePayment();
            $purchasePayment->purchases_id = $purchasesId;
            $purchasePayment->transaction_type_id = $request->transaction_type_id;
            $purchasePayment->amount = $request->payment_amount;
            $purchasePayment->supplier_id = $request->supplier_id;
            $purchasePayment->receipt_no = purchasePaymentReceiptNo();
            $purchasePayment->discount = $discount;
            $purchasePayment->added_by = Auth::user()->id;
            $purchasePayment->created_date = date('Y-m-d');
            $purchasePayment->company_id = Auth::user()->company_id;
            $purchasePayment->save();

            /* <- Purchase Payment log send ->*/
            paymentLogSend($purchasePayment->transaction_type_id, 1, $purchasePayment->amount, $purchasePayment->id);
            return $this->respondWithSuccess('Purchase payment successful', $purchasePayment->id);
        } catch (\Exception $ex) {
            return $this->respondWithError('Something went wrong', $ex->getMessage());
        }
    }

    public function purchasePaySlip(Request $request, $id)
    {
        if ($request->fetch == "true") {
            $purchasePayment = PurchasePayment::select()->where('id', $id)->with('purchase', 'transactionType', 'supplier', 'addedBy', 'addedBy.company')->first();
            return $this->respondWithSuccess('Successfully purchase payment', $purchasePayment);
        } else {
            $purchasePayment = PurchasePayment::select()->where('id', $id)->with('purchase', 'transactionType', 'supplier', 'addedBy', 'addedBy.company')->first();
            return view('payment.purchases.slip', compact('purchasePayment'));
        }
    }



    public function salesPay(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('payment.sales.index');
        }

        try {

            $salesId = "";
            $discount = "";

            if ($request->sales_id) {
                $sales = Sales::find($request->sales_id);
                $sales->paid_amount = floatval($sales->paid_amount) + floatval($request->payment_amount);
                $sales->due_amount = floatval($sales->due_amount) - floatval($request->payment_amount);
                $sales->save();

                $salesId = $sales->id;
                $discount = $sales->discount;
            } else {
                $salesId = null;
                $discount = 0;
            }

            $salesPayment = new SalesPayment();
            $salesPayment->sales_id = $salesId;
            $salesPayment->transaction_type_id = $request->transaction_type_id;
            $salesPayment->amount = $request->payment_amount;
            $salesPayment->customer_id = $request->customer_id;
            $salesPayment->receipt_no = salesPaymentReceiptNo();
            $salesPayment->discount = $discount;
            $salesPayment->added_by = Auth::user()->id;
            $salesPayment->created_date = date('Y-m-d');
            $salesPayment->company_id = Auth::user()->company_id;
            $salesPayment->save();

            /* <- Purchase Payment log send ->*/
            paymentLogSend($salesPayment->transaction_type_id, 3, $salesPayment->amount, $salesPayment->id);
            return $this->respondWithSuccess('Sales payment successful', $salesPayment->id);
        } catch (\Exception $ex) {
            return $this->respondWithError('Something went wrong', $ex->getMessage());
        }
    }


    public function salesPaySlip(Request $request, $id)
    {
        if ($request->fetch == "true") {
            $salesPayment = SalesPayment::select()->where('id', $id)->with('sales', 'transactionType', 'customer', 'addedBy', 'addedBy.company')->first();
            return $this->respondWithSuccess('Successfully purchase payment', $salesPayment);
        } else {
            $salesPayment = SalesPayment::select()->where('id', $id)->with('sales', 'transactionType', 'customer', 'addedBy', 'addedBy.company')->first();
            return view('payment.sales.slip', compact('salesPayment'));
        }
    }

    public function edit(Request $request, $id, $type)
    {
        if ($request->method() == 'GET') {
            $title = ucfirst($type);
            return view('payment.edit', compact('title'));
        }

        try {

            $purchasesId = "";
            $discount = "";

            if ($request->purchase_id) {
                $purchase = Purchase::find($request->purchase_id);
                $purchase->paid_amount = floatval($purchase->paid_amount) + floatval($request->payment_amount);
                $purchase->due_amount = floatval($purchase->due_amount) - floatval($request->payment_amount);
                $purchase->save();

                $purchasesId = $purchase->id;
                $discount = $purchase->discount;
            } else {
                $purchasesId = null;
                $discount = 0;
            }

            $purchasePayment = new PurchasePayment();
            $purchasePayment->purchases_id = $purchasesId;
            $purchasePayment->transaction_type_id = $request->transaction_type_id;
            $purchasePayment->amount = $request->payment_amount;
            $purchasePayment->supplier_id = $request->supplier_id;
            $purchasePayment->receipt_no = purchasePaymentReceiptNo();
            $purchasePayment->discount = $discount;
            $purchasePayment->added_by = Auth::user()->id;
            $purchasePayment->created_date = date('Y-m-d');
            $purchasePayment->company_id = Auth::user()->company_id;
            $purchasePayment->save();

            /* <- Purchase Payment log send ->*/
            paymentLogSend($purchasePayment->transaction_type_id, 1, $purchasePayment->amount, $purchasePayment->id);
            return $this->respondWithSuccess('Purchase payment successful', $purchasePayment->id);
        } catch (\Exception $ex) {
            return $this->respondWithError('Something went wrong', $ex->getMessage());
        }
    }

    public function fetch(Request $request, $id)
    {
        $type = $request->type;
        $payment = "";
        if ($type == 'purchase') {
            $payment = PurchasePayment::select()->where('id', $id)->with('supplier', 'purchase')->first();
        } else {
            $payment = SalesPayment::select()->where('id', $id)->with('customer', 'sales')->first();
        }

        $payment->type = $type;

        return $this->respondWithSuccess('Successfully fetched payment data', $payment);
    }

    public function update(Request $request)
    {
        try {


            if ($request->type == 'purchase') {
                $payment = PurchasePayment::select()->where('id', $request->payment_id)->first();
            } else {
                $payment = SalesPayment::select()->where('id', $request->payment_id)->first();
            }

            $payment->transaction_type_id = $request->transaction_type_id;
            $payment->amount = $request->amount;
            $payment->save();
            return $this->respondWithSuccess('success', 'Successfully updated payment data');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', $th->getMessage());
        }
    }
}
