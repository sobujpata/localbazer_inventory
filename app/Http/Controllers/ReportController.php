<?php

namespace App\Http\Controllers;
use App\Models\Invoice;
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

}
