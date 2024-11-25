<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpensesIncomeHead;
use App\Models\ExpensesIncomeCategory;
use App\Models\TransactionType;
use App\Models\ExpensesIncome;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ExpensesIncomeController extends Controller
{
    public function list(Request $request)
    {
        if ($request->type == 'fetch' && request()->ajax()) {
            $query = ExpensesIncome::orderBy('created_at', 'desc')
                ->where('company_id', Auth::user()->company_id)
                ->with('company', 'addedBy', 'transactionType', 'expensesIncomeHead', 'expensesIncomeCategory')
                ->get();
            return DataTables::of($query)->toJson();
        }
        return view('expenses-income.entry-list');
    }

    public function fetch(Request $request, $id = null)
    {

        if ($request->type == 'create') {
            $expensesIncomeCategories = ExpensesIncomeCategory::select('id','name')->orderBy('created_at', 'desc')
                ->where('company_id', Auth::user()->company_id)
                ->get();
            $expensesIncomeHeads = ExpensesIncomeHead::select('id','name')->orderBy('created_at', 'desc')
                ->where('company_id', Auth::user()->company_id)
                ->get();

            $transactionTypes = TransactionType::select('id','name')->get();

            $data = [
                'expensesIncomeCategories' => $expensesIncomeCategories,
                'expensesIncomeHeads' => $expensesIncomeHeads,
                'transactionTypes' => $transactionTypes,
            ];
            return $this->respondWithSuccess('Successfully fetched data for create', $data);
        }

        if ($id) {
            $expensesIncomes = ExpensesIncome::orderBy('created_at', 'desc')
                ->where('company_id', Auth::user()->company_id)
                ->with('company', 'addedBy', 'transactionType', 'expensesIncomeHead', 'expensesIncomeCategory')
                ->where('id', $id)
                ->first();
        } else {
            $expensesIncomes = ExpensesIncome::orderBy('created_at', 'desc')
                ->where('company_id', Auth::user()->company_id)
                ->with('company', 'addedBy', 'transactionType', 'expensesIncomeHead', 'expensesIncomeCategory')
                ->get();
        }
        return $this->respondWithSuccess('Successfully fetched', $expensesIncomes);
    }


    public function create(Request $request)
    {
        try {
            $expIncomeCategory = new ExpensesIncome();
            $expIncomeCategory->company_id = Auth::user()->company_id;
            $expIncomeCategory->expenses_income_categories_id = $request->category_id;
            $expIncomeCategory->expenses_income_heads_id = $request->head_id;
            $expIncomeCategory->type = $request->type;
            $expIncomeCategory->date = $request->date;
            $expIncomeCategory->transaction_type_id = $request->transactionType_id;
            $expIncomeCategory->amount = $request->amount;
            $expIncomeCategory->status = 1;
            $expIncomeCategory->note = $request->note;
            $expIncomeCategory->created_by = Auth::user()->id;
            $expIncomeCategory->save();

            return $this->respondWithSuccess('success','Successfully created expenses income');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Something went wrong.!');
        }
    }


    public function update(Request $request)
    {
        try {
            $expIncomeCategory = ExpensesIncome::find($request->id);
            $expIncomeCategory->company_id = Auth::user()->company_id;
            $expIncomeCategory->expenses_income_categories_id = $request->category_id;
            $expIncomeCategory->expenses_income_heads_id = $request->head_id;
            $expIncomeCategory->type = $request->type;
            $expIncomeCategory->date = $request->date;
            $expIncomeCategory->transaction_type_id = $request->transactionType_id;
            $expIncomeCategory->amount = $request->amount;
            $expIncomeCategory->status = 1;
            $expIncomeCategory->note = $request->note;
            $expIncomeCategory->created_by = Auth::user()->id;
            $expIncomeCategory->save();
            return $this->respondWithSuccess('success','Successfully updated expenses income');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Something went wrong.!');
        }
    }

    public function delete($id)
    {
        try {
            $expIncomeCategory = ExpensesIncome::find($id);
            $expIncomeCategory->status = 0;
            $expIncomeCategory->save();
            return $this->respondWithSuccess('success','Successfully deleted expenses income');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Something went wrong.!');
        }
    }
}
