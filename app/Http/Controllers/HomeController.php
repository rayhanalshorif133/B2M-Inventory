<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Sales;
use App\Models\ExpensesIncome;
use App\Models\TipsAndTour;
use App\Models\Supplier;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if ($request->type == 'fetch') {
            $company_id = Auth::user()->company_id;
            $data = [
                'totalPurchaseDue' => Purchase::select('due_amount')
                    ->where('company_id', $company_id)
                    ->get()
                    ->sum('due_amount'),

                'totalSalesDue' => Sales::select('due_amount')
                    ->where('company_id', $company_id)
                    ->get()
                    ->sum('due_amount'),

                'totalSalesAmount' => Sales::select('total_amount')
                    ->where('company_id', $company_id)
                    ->get()
                    ->sum('total_amount'),

                'totalExpenseAmount' => ExpensesIncome::select('amount')
                    ->where('company_id', $company_id)
                    ->where('type', '2')
                    ->get()
                    ->sum('amount'),

                'totalsTotalPurchase' => Purchase::select('total_amount')
                    ->where('company_id', $company_id)
                    ->whereDate('created_date', Carbon::today())
                    ->get()
                    ->sum('total_amount'),

                'totalsPaymentReceived' => Sales::select('paid_amount')
                    ->where('company_id', $company_id)
                    ->whereDate('created_date', Carbon::today())
                    ->get()
                    ->sum('paid_amount'),

                'todaysTotalsSales' => Sales::select('total_amount')
                    ->where('company_id', $company_id)
                    ->whereDate('created_date', Carbon::today())
                    ->get()
                    ->sum('total_amount'),

                'todaysTotalsExpense' => ExpensesIncome::select('amount')
                    ->where('company_id', $company_id)
                    ->where('type', '2')
                    ->whereDate('date', Carbon::today())
                    ->get()
                    ->sum('amount'),

                'customers' => Customer::select('id')
                    ->where('company_id', $company_id)
                    ->get()
                    ->count(),

                'suppliers' => Supplier::select('id')
                    ->where('company_id', $company_id)
                    ->get()
                    ->count(),

                'purchaseInvoice' => Purchase::select('id')
                    ->where('company_id', $company_id)
                    ->get()
                    ->count(),

                'salesInvoice' => Sales::select('id')
                    ->where('company_id', $company_id)
                    ->get()
                    ->count(),

            ];

            return $this->respondWithSuccess('Successfully fetched dashboard data', $data);
        }


        if (!TipsAndTour::select()->where('user_id', Auth::user()->id)->first()) {
            $tipsAndSkip = new TipsAndTour();
            $tipsAndSkip->user_id = Auth::user()->id; // Assuming you get the user from the request
            $tipsAndSkip->company_id = Auth::user()->company_id; // Assuming company_id is passed in the request
            $tipsAndSkip->is_viewed = false; // Set default
            $tipsAndSkip->is_skipped = false; // Set default
            $tipsAndSkip->is_favorite = false; // Set default
            $tipsAndSkip->first_viewed_at = Carbon::now(); // Set current timestamp as first viewed time
            $tipsAndSkip->last_viewed_at = Carbon::now(); // Set current timestamp as last viewed time
            $tipsAndSkip->save();
        }


        return view('home');
    }
}
