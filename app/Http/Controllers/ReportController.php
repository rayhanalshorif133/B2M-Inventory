<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use App\Models\SalesDetails;
use App\Models\Supplier;
use App\Models\PurchaseReturn;
use App\Models\Sales;
use App\Models\SalesPayment;
use App\Models\SalesReturn;

class ReportController extends Controller
{

    public function currentStock(Request $request)
    {
        if ($request->type == 'fetch' && request()->ajax()) {
            $query =  ProductAttribute::select()
                ->where('company_id', Auth::user()->company_id)
                ->with('product', 'company')
                ->get();
            return DataTables::of($query)->toJson();
        }
        return view('report.current-stock');
    }


    public function purchase(Request $request)
    {
        if ($request->type == 'fetch' && request()->ajax()) {
            $query = Purchase::select()
                ->where('company_id', Auth::user()->company_id)
                ->with('company', 'supplier')
                ->when($request->start_date && !$request->end_date, function ($query) use ($request) {
                    return $query->where('invoice_date', '=', $request->start_date);
                })
                ->when($request->supplier_id, function ($query) use ($request) {
                    return $query->where('supplier_id', $request->supplier_id);
                })
                ->get();
            return DataTables::of($query)->toJson();
        }

        $suppliers = Supplier::all();
        return view('report.purchase.index', compact('suppliers'));
    }

    public function purchaseReturn(Request $request)
    {
        if ($request->type == 'fetch' && request()->ajax()) {
            $query = PurchaseReturn::select()
                ->where('company_id', Auth::user()->company_id)
                ->with('company', 'supplier')
                ->when($request->start_date && !$request->end_date, function ($query) use ($request) {
                    return $query->where('invoice_date', '=', $request->start_date);
                })
                ->when($request->supplier_id, function ($query) use ($request) {
                    return $query->where('supplier_id', $request->supplier_id);
                })
                ->get();
            return DataTables::of($query)->toJson();
        }

        $suppliers = Supplier::all();
        return view('report.purchase.return', compact('suppliers'));
    }

    public function purchasePayment(Request $request)
    {
        if ($request->type == 'fetch' && request()->ajax()) {
            $query = PurchasePayment::select()
                ->where('company_id', Auth::user()->company_id)
                ->with('purchase', 'supplier', 'transactionType')
                ->when($request->start_date && !$request->end_date, function ($query) use ($request) {
                    return $query->where('created_date', '=', $request->start_date);
                })
                ->when($request->supplier_id, function ($query) use ($request) {
                    return $query->where('supplier_id', $request->supplier_id);
                })
                ->get();
            return DataTables::of($query)->toJson();
        }

        $suppliers = Supplier::all();
        return view('report.purchase.payment', compact('suppliers'));
    }


    public function sales(Request $request)
    {
        if ($request->type == 'fetch' && request()->ajax()) {
            $query = Sales::select()
                ->where('company_id', Auth::user()->company_id)
                ->with('company', 'customer')
                ->when($request->start_date && !$request->end_date, function ($query) use ($request) {
                    return $query->where('invoice_date', '=', $request->start_date);
                })
                ->when($request->customer_id, function ($query) use ($request) {
                    return $query->where('customer_id', $request->customer_id);
                })
                ->get();
            return DataTables::of($query)->toJson();
        }

        $customers = Customer::all();
        return view('report.sales.index', compact('customers'));
    }

    public function salesReturn(Request $request)
    {
        if ($request->type == 'fetch' && request()->ajax()) {
            $query = SalesReturn::select()
                ->where('company_id', Auth::user()->company_id)
                ->with('company', 'customer')
                ->when($request->start_date && !$request->end_date, function ($query) use ($request) {
                    return $query->where('invoice_date', '=', $request->start_date);
                })
                ->when($request->customer_id, function ($query) use ($request) {
                    return $query->where('customer_id', $request->customer_id);
                })
                ->get();
            return DataTables::of($query)->toJson();
        }

        $customers = Customer::all();
        return view('report.sales.return', compact('customers'));
    }


    public function salesPayment(Request $request)
    {
        if ($request->type == 'fetch' && request()->ajax()) {
            $query = SalesPayment::select()
                ->where('company_id', Auth::user()->company_id)
                ->with('sales', 'customer', 'transactionType')
                ->when($request->start_date && !$request->end_date, function ($query) use ($request) {
                    return $query->where('created_date', '=', $request->start_date);
                })
                ->when($request->customer_id, function ($query) use ($request) {
                    return $query->where('customer_id', $request->customer_id);
                })
                ->get();
            return DataTables::of($query)->toJson();
        }

        $customers = Customer::all();
        return view('report.sales.payment', compact('customers'));
    }


    public function profitLoss(Request $request)
    {
        if ($request->type == 'fetch' && $request->based == 'item' && request()->ajax()) {
            // $request->start_date
            // $request->end_date
            $query = DB::table('sales_details')
                ->join('products', 'sales_details.product_id', '=', 'products.id') // Join 'product' table
                ->join('product_attributes', 'sales_details.product_attribute_id', '=', 'product_attributes.id')
                ->join('sales', 'sales_details.sales_id', '=', 'sales.id')
                ->select(
                    'sales_details.product_id',
                    'sales_details.product_attribute_id',
                    'products.name as product_name',
                    'product_attributes.code as p_code',
                    'product_attributes.size as p_size',
                    'product_attributes.color as p_color',
                    DB::raw('SUM(sales_details.qty) as total_qty'),
                    DB::raw('SUM(sales_details.sales_rate) as total_sales_rate'),
                    DB::raw('SUM(sales_details.current_unit_cost * sales_details.qty) as total_unit_cost'),
                    DB::raw('SUM(sales_details.discount) as total_discount'),
                )
                ->groupBy('sales_details.product_id', 'sales_details.product_attribute_id', 'products.name', 'product_attributes.code', 'product_attributes.size', 'product_attributes.color');

            // Check if both start_date and end_date exist in the request


            if ($request->start_date && $request->end_date) {
                $query->whereBetween('sales.invoice_date', [$request->start_date, $request->end_date]);
            } elseif ($request->start_date) {
                $query->where('sales.invoice_date', '=', $request->start_date);
            }

            $data = $query->get();

            return DataTables::of($query)->toJson();
        }


        if ($request->type == 'fetch' && $request->based == 'invoice' && request()->ajax()) {
            $query = Sales::select()->with('customer');
            if ($request->start_date && $request->end_date) {
                $query->whereBetween('invoice_date', [$request->start_date, $request->end_date]);
            } elseif ($request->start_date) {
                $query->where('invoice_date', '=', $request->start_date);
            }

            $sales = $query->get()->each(function ($item) {
                $item->salesDetails = DB::table('sales_details')
                    ->select(
                        'sales_id',
                        DB::raw('SUM(current_unit_cost * qty) as total_unit_cost'), // Sum and alias
                        DB::raw('SUM(discount) as total_discount') // Sum and alias
                    )
                    ->where('sales_id', $item->id)
                    ->groupBy('sales_id') // Group by sales_id
                    ->first();
            });



            return DataTables::of($sales)->toJson();
        }


        return view('report.profit-loss');
    }
}
