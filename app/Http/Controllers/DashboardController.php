<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
        $payable =Invoice::sum('payable');

        return[
            'role'=>$user_role,
            'product'=> $product,
            'category'=> $Category,
            'customer'=> $Customer,
            'invoice'=> $Invoice,
            'total'=> round($total,2),
            'vat'=> round($vat,2),
            'payable'=> round($payable,2)
        ];


    }
}
