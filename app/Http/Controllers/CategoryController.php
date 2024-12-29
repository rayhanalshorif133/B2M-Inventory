<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    public function list()
    {

        $categories = Category::select('id', 'name', 'status')
        ->where('created_by', Auth::user()->id)
        ->where('company_id', Auth::user()->company_id)
        ->where('parent_category_id', null)
        ->get()
        ->each(function ($item) {
            $item->subCategories = Category::select('id', 'name', 'status')->where('parent_category_id', $item->id)->get();
        });
        return view('category.list', compact('categories'));
    }

    public function fetch(Request $request)
    {


        if ($request->type == 'product-create') {
            $categories = Category::select('id', 'name', 'status')
                ->where('created_by', Auth::user()->id)
                ->where('company_id', Auth::user()->company_id)
                ->where('parent_category_id', null)
                ->where('status', 1)
                ->get()
                ->each(function ($item) {
                    $item->subCategories = Category::select('id', 'name', 'status')
                        ->where('status', 1)
                        ->where('parent_category_id', $item->id)->get();
                });
        } else {
            $categories = Category::select('id', 'name', 'status')
                ->where('created_by', Auth::user()->id)
                ->where('company_id', Auth::user()->company_id)
                ->where('parent_category_id', null)
                ->get()
                ->each(function ($item) {
                    $item->subCategories = Category::select('id', 'name', 'status')->where('parent_category_id', $item->id)->get();
                });
        }
        return $this->respondWithSuccess('Fetched categories successfully', $categories);
    }

    public function create(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('category.create');
        }


        try {



            $category = new Category();
            $category->company_id = Auth::user()->company_id;
            $category->name = $request['category_name'];
            $category->status = 1;
            $category->parent_category_id = null;
            $category->created_by = Auth::user()->id;
            $category->save();



            $subCategories = $request['sub_categories'];
            foreach ($subCategories as $item) {
                $subCategory = new Category();
                $subCategory->company_id = $category->company_id;
                $subCategory->name = $item['name'];
                $subCategory->status = 1;
                $subCategory->parent_category_id = $category->id;
                $subCategory->created_by = Auth::user()->id;
                $subCategory->save();
            }
            return $this->respondWithSuccess('success', 'Category  created Successfully');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', $th->getMessage());
        }
    }

    public function addNewSubCategory($category_id, Request $request)
    {
        try {

            // find the category
            $hasAlreadyCategory = Category::select()->where('parent_category_id', $category_id)
                ->where('name', $request->name)
                ->first();
            if($hasAlreadyCategory){
                return $this->respondWithError('Sub category already exists');
            }

            $subCategory = new Category();
            $subCategory->company_id = Auth::user()->company_id;
            $subCategory->name = $request->name;
            $subCategory->status = 1;
            $subCategory->parent_category_id = $category_id;
            $subCategory->created_by = Auth::user()->id;
            $subCategory->save();
            return $this->respondWithSuccess('Successfully added new sub category ', $subCategory);
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Something went wrong');
        }
    }

    public function update($category_id, Request $request)
    {
        try {
            $category = Category::select()->where('id', $category_id)->first();
            $category->status = $request->status;
            $category->name = $request->name;
            $category->save();
            return $this->respondWithSuccess('Updated category successfully', $category);
        } catch (\Throwable $th) {
            // return $this->respondWithError('error', 'Something went wrong');
            return $this->respondWithError('error', $th->getMessage());
        }
    }

    public function delete($category_id, Request $request)
    {
        try {

            if ($request->type == 'child') {
                $category = Category::find($category_id);
                $category->delete();
            } else {

                $getSubCategories = Category::select()->where('parent_category_id', $category_id)->delete();

                $category = Category::find($category_id);
                $category->delete();
            }

            return $this->respondWithSuccess('success', 'Category deleted successfully');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Something went wrong!');
        }
    }
}
