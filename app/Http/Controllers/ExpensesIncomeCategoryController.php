<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpensesIncomeCategory;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ExpensesIncomeCategoryController extends Controller
{
    public function list(Request $request)
    {
        if ($request->type == 'fetch' && request()->ajax()) {
            $query = ExpensesIncomeCategory::orderBy('created_at', 'desc')
                ->where('company_id', Auth::user()->company_id)
                ->with('company', 'addedBy')->get();
            return DataTables::of($query)->toJson();
        }
        return view('expenses-income.category-list');
    }

    public function fetch($id = null)
    {
        if ($id) {
            $expensesIncomeCategories = ExpensesIncomeCategory::orderBy('created_at', 'desc')
                ->where('company_id', Auth::user()->company_id)
                ->with('company', 'addedBy')
                ->where('id', $id)
                ->first();
        } else {
            $expensesIncomeCategories = ExpensesIncomeCategory::orderBy('created_at', 'desc')
                ->where('company_id', Auth::user()->company_id)
                ->with('company', 'addedBy')
                ->get();
        }
        return $this->respondWithSuccess('Successfully fetched expensesIncomeCategories', $expensesIncomeCategories);
    }


    public function create(Request $request)
    {
        try {
            $expIncomeCategory = new ExpensesIncomeCategory();
            $expIncomeCategory->company_id = Auth::user()->company_id;
            $expIncomeCategory->name = $request->name;
            $expIncomeCategory->status = 1;
            $expIncomeCategory->created_by = Auth::user()->id;
            $expIncomeCategory->save();
            return $this->respondWithSuccess('success', 'Successfully created expenses income category');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Something went wrong.!');
        }
    }


    public function update(Request $request)
    {
        try {
            $expIncomeCategory = ExpensesIncomeCategory::find($request->id);
            $expIncomeCategory->company_id = Auth::user()->company_id;
            $expIncomeCategory->name = $request->name;
            $expIncomeCategory->status = 1;
            $expIncomeCategory->created_by = Auth::user()->id;
            $expIncomeCategory->save();
            return $this->respondWithSuccess('success', 'Successfully updated expenses income category');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Something went wrong.!');
        }
    }

    public function delete($id)
    {
        try {
            $expIncomeCategory = ExpensesIncomeCategory::find($id);
            $expIncomeCategory->status = 0;
            $expIncomeCategory->save();
            return $this->respondWithSuccess('success', 'Successfully deleted expenses income category');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Something went wrong.!');
        }
    }
}
