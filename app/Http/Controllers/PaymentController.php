<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchasePayment;
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
            return $this->respondWithSuccess('Purchase payment successful',$purchasePayment->id);
        } catch (\Exception $ex) {
            return $this->respondWithError('Something went wrong', $ex->getMessage());
        }
    }

    public function purchasePaySlip(Request $request, $id)
    {
        if($request->fetch == "true") {
            $purchasePayment = PurchasePayment::select()->where('id', $id)->with('purchase','transactionType','supplier','addedBy','addedBy.company')->first();
            return $this->respondWithSuccess('Successfully purchase payment',$purchasePayment);
        }else{
            $purchasePayment = PurchasePayment::select()->where('id', $id)->with('purchase','transactionType','supplier','addedBy','addedBy.company')->first();
            return view('payment.purchases.slip', compact('purchasePayment'));
        }
    }
}
