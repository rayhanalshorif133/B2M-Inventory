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
        if ($request->type == 'fetch' && request()->ajax()) {
            $query = Product::orderBy('created_at', 'desc')
                ->where('company_id', Auth::user()->company_id)
                ->with('category', 'subCategory')->get();
            return DataTables::of($query)->toJson();
        }

        return view('product.list');
    }



    public function fetch(Request $request, $id = null)
    {

        if ($request->type == 'new-sales') {
            $products = ProductAttribute::select()
                ->where('company_id', Auth::user()->company_id)
                ->where('current_stock', '>', 0)
                ->with('product')
                ->get();
            return $this->respondWithSuccess('Successfully fetched product data', $products);
        }

        if ($id == null) {
            $products = Product::select('id', 'name')
                ->where('company_id', Auth::user()->company_id)->where('status', 1)
                ->get();
        } else {
            $products = Product::select()
                ->where('company_id', Auth::user()->company_id)
                ->where('id', $id)
                ->where('status', 1)
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
                ->with('product')
                ->get();
            return $this->respondWithSuccess('Successfully fetched product attributes data', $productAttributes);
        }

        if ($request->barcode) {
            $productAttributes = ProductAttribute::select()
                ->where('company_id', Auth::user()->company_id)
                ->where('code', 'like', '%' . $request->barcode . '%')
                ->with('product')
                ->get();
            $productAttributes->load('product');
            return $this->respondWithSuccess('Successfully fetched product attributes data', $productAttributes);
        }
    }



    public function create(Request $request)
    {
        if ($request->method() == 'GET') {

            $categories = Category::where('company_id', Auth::user()->company_id)
                ->where('status', 1)
                ->where('parent_category_id', null)
            ->get();
            return view('product.create', compact('categories'));
        }

        try {




            if ($request->type == 'xlsx') {
                $data = $request->data;
                foreach ($data as $item) {

                    if ($item['productName']) {
                        $product = Product::where('name', $item['productName'])->first() ?? new Product();
                        $product->name = $item['productName'];
                        $product->category_id = $item['category_id'];
                        $product->company_id = Auth::user()->company_id;
                        $product->sub_category_id = $item['sub_category_id'];
                        $product->created_by = Auth::user()->id;
                        $product->save();
                    }



                    $productCode = $this->getProductCode();

                    $ProductAttribute = new ProductAttribute();
                    $ProductAttribute->product_id = $product->id;
                    $ProductAttribute->company_id = Auth::user()->company_id;
                    $ProductAttribute->code = $item['productCode'] ? $item['productCode'] : $productCode;
                    $ProductAttribute->size = $item['productSize'] ? $item['productSize'] : null;
                    $ProductAttribute->color = $item['productCode'] ? $item['productCode'] : null;
                    $ProductAttribute->current_stock = $item['currentStock'] ? $item['currentStock'] : null;
                    $ProductAttribute->last_purchase = $item['lastPurchase'] ? $item['lastPurchase'] : null;
                    $ProductAttribute->model = $item['productModel'] ? $item['productModel'] : null;
                    $ProductAttribute->unit_cost = $item['unitCost'] ? $item['unitCost'] : null;
                    $ProductAttribute->sales_rate = $item['salesRate'] ? $item['salesRate'] : null;
                    $ProductAttribute->save();
                }
                return $this->respondWithSuccess('success', 'Successfully uploaded product');
            }

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
            return $this->respondWithError('error', $th->getMessage());
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

    public function showProductDetails($id)
    {
        $product = Product::select()->where('id', $id)->with('category', 'subCategory', 'company')->first();
        $productAttributes = ProductAttribute::where('product_id', $id)->get();
        $data = [
            'product' => $product,
            'productAttributes' => $productAttributes
        ];
        return $this->respondWithSuccess('successfully fetched product details', $data);
    }


    // update
    public function update(Request $request, $id)
    {

        if ($request->type == 'status') {
            $product = Product::find($id);
            $product->status = $product->status == 0 ? 1 : 0;
            $product->save();
            return $this->respondWithSuccess('successfully fetched product details', $product);
        }

        if ($request->type == 'basic-info') {
            $product = Product::find($id);
            $product->category_id = $request->category_id;
            $product->sub_category_id = $request->sub_category_id;
            $product->name = $request->name;
            $product->save();
            $product->load('category', 'subCategory');
            return $this->respondWithSuccess('successfully fetched product details', $product);
        }
        if ($request->type == 'attr-info') {
            $productAttribute = ProductAttribute::find($id);
            $productAttribute->code = $request->code;
            $productAttribute->size = $request->size;
            $productAttribute->model = $request->model;
            $productAttribute->color = $request->color;
            $productAttribute->sales_rate = $request->sales_rate;
            $productAttribute->save();
            return $this->respondWithSuccess('successfully fetched product attribute details',  $productAttribute);
        }
        if ($request->type == 'new-added') {
            $productCode = $this->getProductCode();
            $productAttribute = new ProductAttribute();
            $productAttribute->product_id = $id;
            $productAttribute->company_id = Auth::user()->company_id;
            $productAttribute->code = $request->code ? $request->code : $productCode;
            $productAttribute->size = $request->size ? $request->size : null;
            $productAttribute->model = $request->model ? $request->model : null;
            $productAttribute->color = $request->color ? $request->color : null;
            $productAttribute->sales_rate = $request->sales_rate ? $request->sales_rate : 0;
            $productAttribute->last_purchase = $request->last_purchase ? $request->last_purchase : 0;
            $productAttribute->unit_cost = $request->unit_cost ? $request->unit_cost : 0;
            $productAttribute->current_stock = $request->current_stock ? $request->current_stock : 0;
            $productAttribute->save();
            return $this->respondWithSuccess('successfully product attribute added',  $productAttribute);
        }
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
