<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesDetails;
use App\Models\Sales;
use App\Models\SalesPayment;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use App\Models\SalesReturnDetails;
use App\Models\SalesReturnPayment;
use Illuminate\Support\Facades\DB;


class CommonController extends Controller
{
    // invoice
    public function invoice($type, $id)
    {

        $print_date = date('Y-m-d');
        $invoice_name = $type . ' Invoice';

        if ($type == 'sales') {

            $itemDetails = DB::table('sales_details')
                ->join('products', 'sales_details.product_id', '=', 'products.id')
                ->join('product_attributes', 'sales_details.product_attribute_id', '=', 'product_attributes.id')
                ->where('sales_details.sales_id', $id)
                ->get();

            $item = Sales::select()->where('id', $id)->with('company', 'customer', 'createdBy')->first();
            $payment = SalesPayment::select()->where('sales_id', $item->id)->with('transactionType')->first();
            $invoice_name = 'Invoice';
        }

        if ($type == 'purchase') {

            $itemDetails = DB::table('purchase_details')
                ->join('products', 'purchase_details.product_id', '=', 'products.id')
                ->join('product_attributes', 'purchase_details.product_attribute_id', '=', 'product_attributes.id')
                ->where('purchase_details.purchases_id', $id)
                ->get();

            $item = Purchase::select()->where('id', $id)->with('company', 'supplier', 'createdBy')->first();
            $payment = PurchasePayment::select()->where('purchases_id', $item->id)->with('transactionType')->first();
            $invoice_name = 'Invoice';
        }

        return view('_partials.inovice', compact('print_date', 'item', 'itemDetails', 'payment', 'type', 'invoice_name'));
    }
}
