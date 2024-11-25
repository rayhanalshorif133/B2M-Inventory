<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpensesIncomeHead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ExpensesIncomeHeadController extends Controller
{
    public function list(Request $request)
    {
        if ($request->type == 'fetch' && request()->ajax()) {
            $query = ExpensesIncomeHead::orderBy('created_at', 'desc')
                ->where('company_id', Auth::user()->company_id)
                ->with('expensesIncomeCategories', 'company','addedBy')->get();
            return DataTables::of($query)->toJson();
        }

        return view('expenses-income.head-list');
    }

    public function fetch($id = null)
    {
        if ($id) {
            $expensesIncomeHead = ExpensesIncomeHead::orderBy('created_at', 'desc')
                ->where('company_id', Auth::user()->company_id)
                ->with('expensesIncomeCategories', 'company','addedBy')
                ->where('id', $id)
                ->first();
        } else {
            $expensesIncomeHead = ExpensesIncomeHead::orderBy('created_at', 'desc')
                ->where('company_id', Auth::user()->company_id)
                ->with('expensesIncomeCategories', 'company','addedBy')
                ->get();
        }
        return $this->respondWithSuccess('Successfully fetched expenses Income Head', $expensesIncomeHead);
    }


    public function create(Request $request)
    {
        try {
            $expIncomeHead = new ExpensesIncomeHead();
            $expIncomeHead->company_id = Auth::user()->company_id;
            $expIncomeHead->name = $request->name;
            $expIncomeHead->expenses_income_categories_id = $request->expIncomeCategoryId;
            $expIncomeHead->status = 1;
            $expIncomeHead->created_by = Auth::user()->id;
            $expIncomeHead->save();
            return $this->respondWithSuccess('success','Successfully create new income head');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Something went wrong.!');
        }
    }


    public function update(Request $request)
    {
        try {
            $expIncomeHead = ExpensesIncomeHead::find($request->id);
            $expIncomeHead->company_id = Auth::user()->company_id;
            $expIncomeHead->name = $request->name;
            $expIncomeHead->expenses_income_categories_id = $request->expIncomeCategoryId;
            $expIncomeHead->status = 1;
            $expIncomeHead->created_by = Auth::user()->id;
            $expIncomeHead->save();
            return $this->respondWithSuccess('success','Successfully updated new income head');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Something went wrong.!');
        }
    }

    public function delete($id)
    {
        try {
            $expIncomeHead = ExpensesIncomeHead::find($id);
            $expIncomeHead->status = 0;
            $expIncomeHead->save();
            return $this->respondWithSuccess('success', 'Successfully deleted expenses income head');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Something went wrong.!');
        }
    }
}
