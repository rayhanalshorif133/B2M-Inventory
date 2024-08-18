<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;


class ProductController extends Controller
{
    public function list(Request $request)
    {
        if (request()->ajax()) {
            $query = Product::orderBy('created_at', 'desc')
                ->where('company_id', Auth::user()->company_id)
                ->with('category', 'subCategory')->get();
            return DataTables::of($query)->toJson();
        }
        return view('product.list');
    }

    public function fetch($id = null)
    {
        if ($id == null) {
            $products = Product::select('id', 'name')->where('company_id', Auth::user()->company_id)->get();
        } else {
            $products = Product::select()
                ->where('company_id', Auth::user()->company_id)
                ->where('id', $id)
                ->first();
        }
        return $this->respondWithSuccess('Successfully fetched product data', $products);
    }

    public function fetchAttribute(Request $request)
    {
        if ($request->product_attribute_id) {
            $productAttributes = ProductAttribute::select()
                ->where('company_id', Auth::user()->company_id)
                ->where('id', $request->product_attribute_id)
                ->with('product')
                ->first();
            return $this->respondWithSuccess('Successfully fetched product attributes data', $productAttributes);
        }

        if ($request->product_id) {
            $productAttributes = ProductAttribute::select()
                ->where('company_id', Auth::user()->company_id)
                ->where('product_id', $request->product_id)
                ->get();
            return $this->respondWithSuccess('Successfully fetched product attributes data', $productAttributes);
        }

        if ($request->barcode) {
            $productAttributes = ProductAttribute::select()
                ->where('company_id', Auth::user()->company_id)
                ->where('code', $request->barcode)
                ->with('product')
                ->get();
            $productAttributes->load('product');
            return $this->respondWithSuccess('Successfully fetched product attributes data', $productAttributes);
        }
    }



    public function create(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('product.create');
        }

        try {


            $product = new Product();
            $product->name = $request['productName'];
            $product->category_id = $request['category_id'];
            $product->company_id = Auth::user()->company_id;
            $product->sub_category_id = $request['sub_category_id'];
            $product->created_by = Auth::user()->id;
            $product->save();

            $productCode = $this->getProductCode();

            $productDetailsInfos = $request['productDetailsInfos'];

            foreach ($productDetailsInfos as $item) {

                $ProductAttribute = new ProductAttribute();
                $ProductAttribute->product_id = $product->id;
                $ProductAttribute->company_id = Auth::user()->company_id;
                $ProductAttribute->code = $item['code'] ? $item['code'] : $productCode;
                $ProductAttribute->size = $item['size'] ? $item['size'] : null;
                $ProductAttribute->color = $item['color'] ? $item['color'] : null;
                $ProductAttribute->current_stock = $item['current_stock'] ? $item['current_stock'] : null;
                $ProductAttribute->last_purchase = $item['lastPurchase'] ? $item['lastPurchase'] : null;
                $ProductAttribute->model = $item['model'] ? $item['model'] : null;
                $ProductAttribute->unit_cost = $item['unit_cost'] ? $item['unit_cost'] : null;
                $ProductAttribute->sales_rate = $item['sales_rate'] ? $item['sales_rate'] : null;
                $ProductAttribute->save();
            }


            return $this->respondWithSuccess('success', 'Successfully created product');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Something went wrong');
        }
    }

    public function checkDuplicateCode($code)
    {
        $product = ProductAttribute::where('company_id', Auth::user()->company_id)->where('code', $code)->first();

        if ($product) {
            return $this->respondWithError('error', 'Duplicate code already exists.');
        }

        return $this->respondWithSuccess('success', 'Code is unique');
    }

    // getProductCode
    public function getProductCode()
    {
        $code = '#P_' . random_int(000000, 999999);
        $product = ProductAttribute::where('company_id', Auth::user()->company_id)->where('code', $code)->first();

        if ($product) {
            return $this->getProductCode();
        }
        return $code;
    }
}
