<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Invoice;
use App\Models\Customer;

class CollectionController extends Controller
{
    public function index(){
        // Fetch collections and map the data as shown in the previous code
        $collections = Collection::all()->map(function($collection) {
            $invoice = Invoice::where('id', $collection->invoice_id)->first();
            $customer_name = $invoice ? Customer::where('id', $invoice->customer_id)->first()->shop_name ?? 'Unknown' : 'Unknown';

            return [
                'collection_id' => $collection->id,
                'amount' => $collection->amount,
                'invoice_id' => $collection->invoice_id,
                'customer_name' => $customer_name,
                'invoice_url' => $collection->invoice_url,
            ];
        });

        // Pass data to Blade view
        // return view('collections', compact('collections'));
        return view('collection.collections', compact('collections'));
    }
    public function CollectionCreate(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0',
            'invoice_url' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        // Retrieve user_id from the request header or session (make sure it's available)
        $user_id = $request->header('id');  // Ensure this is correctly passed in the headers

        if (!$user_id) {
            return redirect()->back()->withErrors(['user_id' => 'User ID is missing.']);
        }

        $invoice_id = $request->input('invoice_id');
        $amount = $request->input('amount');

        // Check for duplicate invoice_id in the collections table
        $duplicate = Collection::where('invoice_id', $invoice_id)->exists();

        if ($duplicate) {
            // If the invoice_id already exists, return back with an error message
            return redirect()->back()->withErrors(['invoice_id' => 'This invoice has already been processed.']);
        }

        // Check if the file was uploaded
        if ($request->hasFile('invoice_url')) {
            $img = $request->file('invoice_url');

            // Create a unique file name
            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$user_id}-{$t}-{$file_name}";
            $img_url = "collection-invoice/{$img_name}";

            // Upload file to public/collection-invoice directory
            $img->move(public_path('collection-invoice'), $img_name);
        } else {
            return redirect()->back()->withErrors(['invoice_url' => 'File upload failed. Please try again.']);
        }

        // Create the collection entry in the database
        Collection::create([
            'user_id' => $user_id,
            'invoice_id' => $invoice_id,
            'amount' => $amount,
            'invoice_url' => $img_url,
        ]);

        // Return a success response
        return redirect()->back()->with('message', 'Collection amount submitted successfully.');
    }

}
