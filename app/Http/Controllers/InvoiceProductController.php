<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\InvoiceProduct;
use Illuminate\Support\Facades\DB;
// app/Http/Controllers/InvoiceProductController.php


class InvoiceProductController extends Controller
{
    public function index(Request $request)
    {
        // Initialize a base query for invoices
        $query = InvoiceProduct::query();

        // Check if 'invoice' parameter is present and not empty
        if ($request->has('invoice') && $request->invoice != '') {
            // Split the invoice input by spaces into an array of IDs
            $invoice_ids = explode(' ', $request->invoice);
            
            // Get all matching invoices using whereIn with the array of invoice_ids
            $query->whereIn('invoice_id', $invoice_ids);
        }

        // Retrieve all matching invoices
        $invoices = $query->get();

        // If invoices are found, get their invoice IDs and query InvoiceProduct
        if ($invoices->isNotEmpty()) {
            $invoice_ids = $invoices->pluck('invoice_id')->toArray();

            // Get distinct product_id and sum of quantities across multiple invoices
            $invoice_products = InvoiceProduct::select('product_id', DB::raw('SUM(qty) as total_qty'))
                                              ->whereIn('invoice_id', $invoice_ids)
                                              ->groupBy('product_id')
                                              ->with('product')
                                              ->get();
        } else {
            // No matching invoices found, set an empty collection for invoice_products
            $invoice_products = collect();
        }

        // Return the search result view
        return view('pages.dashboard.invoice-product-search', compact('invoice_products'));
    }
}

