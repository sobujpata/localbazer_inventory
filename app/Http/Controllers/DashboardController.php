<?php

namespace App\Http\Controllers;
use carbon\Carbon;
use App\Models\Bank;
use App\Models\Invoice;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\View\View;
use App\Models\BuyProduct;
use App\Models\Collection;
use Illuminate\Http\Request;
use App\Models\InvoiceProduct;
use App\Models\LoanRepayBalance;
use App\Models\MiscellaneousCost;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function DashboardPage():View{
        return view('pages.dashboard.dashboard-page');
    }

    function Summary(Request $request):array{

        $user_id=$request->header('id');
        $user_role = $request->header('role');

        $product= Product::count();
        $Category= Category::count();
        $Customer=Customer::count();
        $Invoice= Invoice::count();
        $total=  Invoice::sum('total');
        $vat= Invoice::sum('vat');
        $collection =Collection::sum('amount');
        $due =Collection::sum('due');
        $buy_product =BuyProduct::sum('product_cost');
        $total_store_product_price =Product::sum(DB::raw('buy_price * buy_qty'));

        // Original sale price
        $total_sale_buy_price = $buy_product - $total_store_product_price;
        //Nite sale income
        $total_sale_income = $collection - $total_sale_buy_price;

        //total_cost
        $total_cost = MiscellaneousCost::sum('amount');

        //Total Deposit from partners
        $total_deposit = Partner::sum('amount');

        $bank_loan = Bank::sum('loan_amount');
        $bank_loan_repay = LoanRepayBalance::sum('pay_amount');

        $total_deposit_with_collection = $total_deposit + $collection + $bank_loan;

        //live balance
        $live_balance =$total_deposit_with_collection - $total_cost - $bank_loan_repay;






        $currentDate = Carbon::today();

        // Get the start and end dates for the previous month
        $startOfLastMonth = Carbon::now()->startOfMonth()->subMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        // dd($endOfLastMonth);
        // Sum the total for rentals from last month
        $total_last_month_earn = Invoice::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
                               ->sum('total');
        $total_last_month_earn_collection = Collection::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
                               ->sum('amount');
        $total_last_month_due = Collection::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
                               ->sum('due');
        $total_last_month_buy_product = BuyProduct::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
                               ->sum('product_cost');

        // Get the start and end dates for the current month
        $startOfCurrentMonth = Carbon::now()->startOfMonth();
        $endOfCurrentMonth = Carbon::now()->endOfMonth();

        // Sum the total for rentals in the current month
        $total_current_month_earn = Invoice::whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])
                                        ->sum('total');
        $total_current_month_earn_collection = Collection::whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])
                                        ->sum('amount');
        $total_current_month_due = Collection::whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])
                                        ->sum('due');
        $total_current_month_buy_product = BuyProduct::whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])
                                        ->sum('product_cost');
                                        // dd($total_current_month_buy_product);
        // Get the start and end dates for the last week
        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek(Carbon::SUNDAY);  // Start of last week (Sunday)
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek(Carbon::SATURDAY);    // End of last week (Saturday)

        // Sum the total for rentals from last week
        $total_last_week_earn = Invoice::whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
                              ->sum('total');
        $total_last_week_earn_collection = Collection::whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
                              ->sum('amount');
        $total_last_week_due = Collection::whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
                              ->sum('due');
        $total_last_week_buy_product = BuyProduct::whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
                              ->sum('product_cost');


        // Get the start and end dates for the current week
        $startOfCurrentWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY);  // Start of this week (Sunday)
        $endOfCurrentWeek = Carbon::now()->endOfWeek(Carbon::SATURDAY);    // End of this week (Saturday)

        // Sum the total for rentals from the current week
        $total_current_week_earn = Invoice::whereBetween('created_at', [$startOfCurrentWeek, $endOfCurrentWeek])
                                 ->sum('total');
        $total_current_week_earn_collection = Collection::whereBetween('created_at', [$startOfCurrentWeek, $endOfCurrentWeek])
                                 ->sum('amount');
        $total_current_week_due = Collection::whereBetween('created_at', [$startOfCurrentWeek, $endOfCurrentWeek])
                                 ->sum('due');
        $total_current_week_buy_product = BuyProduct::whereBetween('created_at', [$startOfCurrentWeek, $endOfCurrentWeek])
                                 ->sum('product_cost');


                                 // Get the start and end of the previous day
        $startOfPreviousDay = Carbon::yesterday()->startOfDay();  // Start of yesterday
        $endOfPreviousDay = Carbon::yesterday()->endOfDay();      // End of yesterday

        // Sum the total for rentals from the previous day
        $total_previous_day_earn = Invoice::whereBetween('created_at', [$startOfPreviousDay, $endOfPreviousDay])
                                 ->sum('total');
        $total_previos_invoice = Invoice::whereBetween('created_at', [$startOfPreviousDay, $endOfPreviousDay])
                                 ->count();
        $total_previous_day_earn_collection = Collection::whereBetween('created_at', [$startOfPreviousDay, $endOfPreviousDay])
                                 ->sum('amount');
        $collection_previous_day_invoice = Collection::whereBetween('created_at', [$startOfPreviousDay, $endOfPreviousDay])
                                 ->count();
        $total_previous_day_due = Collection::whereBetween('created_at', [$startOfPreviousDay, $endOfPreviousDay])
                                 ->sum('due');
        $total_previous_day_buy_product = BuyProduct::whereBetween('created_at', [$startOfPreviousDay, $endOfPreviousDay])
                                 ->sum('product_cost');

        // Get the start of today and the current time
        $startOfToday = Carbon::today()->startOfDay();  // Start of today (00:00:00)
        $endOfToday = Carbon::now();                    // Current time (now)

        // Sum the total for rentals created today
        $total_today_earn = Invoice::whereBetween('created_at', [$startOfToday, $endOfToday])
                           ->sum('total');
        $total_today_invoice = Invoice::whereBetween('created_at', [$startOfToday, $endOfToday])
                           ->count();
        $total_today_earn_collection = Collection::whereBetween('created_at', [$startOfToday, $endOfToday])
                           ->sum('amount');
        $collection_today_invoice = Collection::whereBetween('created_at', [$startOfToday, $endOfToday])
                           ->count();
        $total_today_due = Collection::whereBetween('created_at', [$startOfToday, $endOfToday])
                           ->sum('due');
        $total_today_buy_product = BuyProduct::whereBetween('created_at', [$startOfToday, $endOfToday])
                           ->sum('product_cost');


        // Get the current month start and end dates
        $startOfMonth = Carbon::now()->startOfMonth();  // Start of the current month (1st day)
        $endOfMonth = Carbon::now()->endOfMonth();      // End of the current month (last day)

        // Retrieve and group invoices by day, summing the total for each day
        $daily_totals = Invoice::select(
                            DB::raw('DATE(created_at) as date'), // Group by date
                            DB::raw('SUM(total) as total')       // Sum totals for each day
                        )
                        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                        ->groupBy(DB::raw('DATE(created_at)'))  // Group by date
                        ->get();


        $chartData = [
            'labels' => $daily_totals->pluck('date'),  // Extract dates
            'data' => $daily_totals->pluck('total'),   // Extract total sums
        ];

        // Retrieve and group Collection by day, summing the total for each day
        $daily_totals_collection = Collection::select(
                            DB::raw('DATE(created_at) as date'), // Group by date
                            DB::raw('SUM(amount) as total')       // Sum totals for each day
                        )
                        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                        ->groupBy(DB::raw('DATE(created_at)'))  // Group by date
                        ->get();


        $chartDataCollection = [
            'labels_collection' => $daily_totals_collection->pluck('date'),  // Extract dates
            'data_collection' => $daily_totals_collection->pluck('amount'),   // Extract total sums
        ];

        //month wise chart
        $month_wise_invoice = DB::table('invoices')
        ->select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(payable) as total_earnings')
        )
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();

        // // Fetch month-wise total earnings and total costs
        //     $monthlyData = DB::table('invoices')
        //     ->select(
        //         DB::raw('YEAR(created_at) as year'),
        //         DB::raw('MONTH(created_at) as month'),
        //         DB::raw('SUM(payable) as total_earnings')
        //     )
        //     ->where('complete', 1) // Adjust this condition based on your data
        //     ->groupBy('year', 'month');

        // // Add total costs from products (join invoice_products and products)
        // $monthlyData = $monthlyData->leftJoin('invoice_products', 'invoices.id', '=', 'invoice_products.invoice_id')
        //     ->leftJoin('products', 'invoice_products.product_id', '=', 'products.id')
        //     ->addSelect(DB::raw('SUM(products.buy_price * invoice_products.qty) as total_cost'))
        //     ->get();

        // // Calculate net earnings for each month
        // $formattedData = $monthlyData->map(function ($data) {
        //     return [
        //         'year' => $data->year,
        //         'month' => $data->month,
        //         'net_earnings' => $data->total_earnings - $data->total_cost,
        //     ];
        // });


        $alltotalBuyPrice = InvoiceProduct::join('products', 'invoice_products.product_id', '=', 'products.id') // Join the product table
            ->select(DB::raw('SUM(products.buy_price * invoice_products.qty) as total_buy_price')) // Calculate the sum
            ->value('total_buy_price'); // Retrieve the aggregated value

        // Get the start and end dates for last month
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        // Calculate the total for last month
        $totalBuyPriceLastMonth = InvoiceProduct::whereBetween('invoice_products.created_at', [$startOfLastMonth, $endOfLastMonth])
            ->join('products', 'invoice_products.product_id', '=', 'products.id')
            ->select(DB::raw('SUM(products.buy_price * invoice_products.qty) as total_buy_price'))
            ->value('total_buy_price');
        // Calculate the total for current month
        $totalBuyPriceCurrentMonth = InvoiceProduct::whereBetween('invoice_products.created_at', [$startOfCurrentMonth, $endOfCurrentMonth])
            ->join('products', 'invoice_products.product_id', '=', 'products.id')
            ->select(DB::raw('SUM(products.buy_price * invoice_products.qty) as total_buy_price'))
            ->value('total_buy_price');

        return[
            'role'=>$user_role,
            'product'=> $product,
            'category'=> $Category,
            'customer'=> $Customer,
            'invoice'=> $Invoice,
            'total_deposit_with_collection'=>round($total_deposit_with_collection, 2),
            'total_cost'=> round($total_cost, 2),
            'total_store_product_price'=> round($total_store_product_price, 2),
            'total_sale_income'=>round($total_sale_income,2),
            'live_balance'=>round($live_balance,2),
            'total'=> round($total,2),
            'total_last_month_earn'=> round($total_last_month_earn,2),
            'total_current_month_earn'=> round($total_current_month_earn,2),
            'total_last_week_earn'=> round($total_last_week_earn,2),
            'total_current_week_earn'=> round($total_current_week_earn,2),
            'total_previous_day_earn'=> round($total_previous_day_earn,2),
            'total_today_earn'=> round($total_today_earn,2),
            'total_today_invoice' => $total_today_invoice,
            'total_previos_invoice' => $total_previos_invoice,
            //Collection Details
            'collection'=> round($collection,2),
            'total_last_month_earn_collection'=> round($total_last_month_earn_collection,2),
            'total_current_month_earn_collection'=> round($total_current_month_earn_collection,2),
            'total_last_week_earn_collection'=> round($total_last_week_earn_collection,2),
            'total_current_week_earn_collection'=> round($total_current_week_earn_collection,2),
            'total_previous_day_earn_collection'=> round($total_previous_day_earn_collection,2),
            'total_today_earn_collection'=> round($total_today_earn_collection,2),
            'collection_today_invoice'=> round($collection_today_invoice,2),
            'collection_previous_day_invoice'=> round($collection_previous_day_invoice,2),
            //Due Amount
            'due'=> round($due,2),
            'total_last_month_due'=> round($total_last_month_due,2),
            'total_current_month_due'=> round($total_current_month_due,2),
            'total_last_week_due'=> round($total_last_week_due,2),
            'total_current_week_due'=> round($total_current_week_due,2),
            'total_previous_day_due'=> round($total_previous_day_due,2),
            'total_today_due'=> round($total_today_due,2),
            //Buy Product cost
            'buy_product'=> round($buy_product,2),
            'total_last_month_buy_product'=> round($total_last_month_buy_product,2),
            'total_current_month_buy_product'=> round($total_current_month_buy_product,2),
            'total_last_week_buy_product'=> round($total_last_week_buy_product,2),
            'total_current_week_buy_product'=> round($total_current_week_buy_product,2),
            'total_previous_day_buy_product'=> round($total_previous_day_buy_product,2),
            'total_today_buy_product'=> round($total_today_buy_product,2),

            //Order details chart
            'chartData' =>$chartData,
            'labels' => $daily_totals->pluck('date'),  // Extract dates
            'data' => $daily_totals->pluck('total'),   // Extract total sums
            //collection Chart
            'chartData_collection' =>$chartDataCollection,
            'labels_collection' => $daily_totals_collection->pluck('date'),  // Extract dates
            'data_collection' => $daily_totals_collection->pluck('total'),   // Extract total sums

            //month wise chart
            'month_wise_invoice'=>$month_wise_invoice,

            //Month wise net earn
            // 'month_wise_net_eanr'=>$formattedData,
            

            //Total Earn
            'total_earn'=>round($total - $alltotalBuyPrice, 2),
            'total_earn_last_month'=>round($total_last_month_earn - $totalBuyPriceLastMonth, 2),
            'total_earn_current_month'=>round($total_current_month_earn - $totalBuyPriceCurrentMonth, 2),
        ];


    }
}
