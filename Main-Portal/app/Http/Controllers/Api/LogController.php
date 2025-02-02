<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductLog;
use App\Models\TransactionLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
     // /api/log/product?product_attribute_id=1&type=1&qty=219&ref_id=1
     public function productLog(Request $request)
     {
         try {

             if (!$request->product_attribute_id || !$request->type || !$request->ref_id || !$request->qty) {
                 return $this->respondWithError('Product attribute id, type, ref_id and qty are required');
             }

             $productLog = new ProductLog();
             $productLog->product_attribute_id = $request->product_attribute_id;
             $productLog->type = $request->type;
             $productLog->qty = $request->qty;
             $productLog->opt_date = date('Y-m-d');
             $productLog->ref_id = $request->ref_id;
             $productLog->save();
             return $this->respondWithSuccess('Product Log created successfully', $productLog);
         } catch (\Throwable $th) {
             return $this->respondWithError('Something went wrong.!', $th->getMessage());
         }
     }

     // /api/log/transection?transaction_type_id=1&type=1&amount=219&ref_id=1
     public function transectionLog(Request $request)
     {
         try {
             $transactionLog = new TransactionLog();
             $transactionLog->transaction_type_id = $request->transaction_type_id;
             $transactionLog->amount = $request->amount;
             $transactionLog->type = $request->type;
             $transactionLog->opt_date = date('Y-m-d');
             $transactionLog->ref_id = $request->ref_id;
             $transactionLog->save();

             return $this->respondWithSuccess('Transaction Log created successfully', $transactionLog);
            return redirect()->back();
         } catch (\Throwable $th) {
             return $this->respondWithError('Something went wrong.!', $th->getMessage());
         }
     }
}
