<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesDetails;
use App\Models\Sales;
use App\Models\SalesPayment;


class CommonController extends Controller
{
    // invoice
    public function invoice($type, $id)
    {

        $print_date = date('Y-m-d');
        $invoice_name = $type . ' Invoice';

        if ($type == 'sales') {
            $itemDetails = SalesDetails::select()->where('sales_id', $id)
                ->with('product', 'productAttribute')
                ->get();

            $item = Sales::select()->where('id', $id)->with('company', 'customer', 'createdBy')->first();
            $payment = SalesPayment::select()->where('sales_id', $item->id)->with('transactionType')->first();
            $invoice_name = 'Invoice';
        }



        return view('_partials.inovice', compact('print_date', 'item', 'itemDetails', 'payment', 'type', 'invoice_name'));
    }
}
