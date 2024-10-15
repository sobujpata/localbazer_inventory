<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvoiceProduct;
use Illuminate\Support\Facades\DB;

class InvoiceProductController extends Controller
{
    public function index(){

        $invoice_products = InvoiceProduct::select('product_id', DB::raw('SUM(qty) as total_qty'))
                                      ->groupBy('product_id')
                                      ->get();
        return view('pages.dashboard.invoice-product-search', compact('invoice_products', ));
    }
}
