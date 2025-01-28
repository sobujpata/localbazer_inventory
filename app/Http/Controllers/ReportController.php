<?php

namespace App\Http\Controllers;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{


    function ReportPage(){
        return view('pages.dashboard.report-page');
    }

    function SalesReport(Request $request){

        $user_id=$request->header('id');
        $FormDate=date('Y-m-d',strtotime($request->FormDate));
        $ToDate=date('Y-m-d',strtotime($request->ToDate));

        $total=Invoice::whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('total');
        $vat=Invoice::whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('vat');
        $payable=Invoice::whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('payable');
        $discount=Invoice::whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('discount');



        $list=Invoice::whereDate('created_at', '>=', $FormDate)
            ->whereDate('created_at', '<=', $ToDate)
            ->with('customer')->get();




        $data=[
            'payable'=> $payable,
            'discount'=>$discount,
            'total'=> $total,
            'vat'=> $vat,
            'list'=>$list,
            'FormDate'=>$request->FormDate,
            'ToDate'=>$request->FormDate
        ];


        $pdf = Pdf::loadView('report.SalesReport',$data);


        return $pdf->download('invoice.pdf');

    }

    function CategoryWiseProduct(Request $request){
        $category_id = $request->categoryId;

        if($category_id == "all"){
            $products = Product::orderBy('eng_name', 'ASC')->get();

            $data = [
                'products'=>$products,
            ];
            $pdf = Pdf::loadView('report.categoryProducts', $data);
    
            return $pdf->download('products.pdf');
        }else{
            $products = Product::where('category_id', $category_id)->orderBy('eng_name', "ASC")->get();

            $data = [
                'products'=>$products,
            ];
            $pdf = Pdf::loadView('report.categoryProducts', $data);
    
            return $pdf->download('products.pdf');
        }
        
    }

}
