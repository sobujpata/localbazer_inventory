<?php

namespace App\Http\Controllers;
use carbon\Carbon;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\View\View;
use App\Models\Collection;
use Illuminate\Http\Request;
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




        $currentDate = Carbon::today();
        // dd($currentDate);
        // Count current rentals where the start date is in the past or today and the end date is in the future or today
        // $currentRentals = Invoice::where('created_at', '<=', $currentDate)
        //                  ->where('end_date', '>=', $currentDate)
        //                  ->count();
        // $available_cars = $cars - $currentRentals;

        // $total_earn = Invoice::sum('total');

        // Get the start and end dates for the previous month
        $startOfLastMonth = Carbon::now()->startOfMonth()->subMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        // dd($endOfLastMonth);
        // Sum the total for rentals from last month
        $total_last_month_earn = Invoice::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
                               ->sum('total');

        // Get the start and end dates for the current month
        $startOfCurrentMonth = Carbon::now()->startOfMonth();
        $endOfCurrentMonth = Carbon::now()->endOfMonth();

        // Sum the total for rentals in the current month
        $total_current_month_earn = Invoice::whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])
                                        ->sum('total');

        // Get the start and end dates for the last week
        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek(Carbon::SUNDAY);  // Start of last week (Sunday)
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek(Carbon::SATURDAY);    // End of last week (Saturday)

        // Sum the total for rentals from last week
        $total_last_week_earn = Invoice::whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
                              ->sum('total');


        // Get the start and end dates for the current week
        $startOfCurrentWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY);  // Start of this week (Sunday)
        $endOfCurrentWeek = Carbon::now()->endOfWeek(Carbon::SATURDAY);    // End of this week (Saturday)

        // Sum the total for rentals from the current week
        $total_current_week_earn = Invoice::whereBetween('created_at', [$startOfCurrentWeek, $endOfCurrentWeek])
                                 ->sum('total');

        
                                 // Get the start and end of the previous day
        $startOfPreviousDay = Carbon::yesterday()->startOfDay();  // Start of yesterday
        $endOfPreviousDay = Carbon::yesterday()->endOfDay();      // End of yesterday

        // Sum the total for rentals from the previous day
        $total_previous_day_earn = Invoice::whereBetween('created_at', [$startOfPreviousDay, $endOfPreviousDay])
                                 ->sum('total');
        
        // Get the start of today and the current time
        $startOfToday = Carbon::today()->startOfDay();  // Start of today (00:00:00)
        $endOfToday = Carbon::now();                    // Current time (now)

        // Sum the total for rentals created today
        $total_today_earn = Invoice::whereBetween('created_at', [$startOfToday, $endOfToday])
                           ->sum('total');


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

        return[
            'role'=>$user_role,
            'product'=> $product,
            'category'=> $Category,
            'customer'=> $Customer,
            'invoice'=> $Invoice,
            'total'=> round($total,2),
            'total_last_month_earn'=> round($total_last_month_earn,2),
            'total_current_month_earn'=> round($total_current_month_earn,2),
            'total_last_week_earn'=> round($total_last_week_earn,2),
            'total_current_week_earn'=> round($total_current_week_earn,2),
            'total_previous_day_earn'=> round($total_previous_day_earn,2),
            'total_today_earn'=> round($total_today_earn,2),
            'collection'=> round($collection,2),

            'chartData' =>$chartData,
            'labels' => $daily_totals->pluck('date'),  // Extract dates
            'data' => $daily_totals->pluck('total'),   // Extract total sums
        ];


    }
}
