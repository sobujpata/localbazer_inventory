<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Invoice;
use App\Models\Customer;

class CollectionController extends Controller
{
    public function index(Request $request)
{
    // Fetch collections with relationships
    $query = Collection::with('invoice.customer')->orderBy('invoice_id', 'desc');

    // Apply filter by invoice_id if selected
    if ($request->filled('invoice_id')) {
        $query->where('invoice_id', $request->invoice_id);
    }

    // Get paginated and mapped data
    $collections = $query->paginate(12)->through(function ($collection) {
        return [
            'collection_id' => $collection->id,
            'amount' => $collection->amount,
            'due' => $collection->due,
            'invoice_id' => $collection->invoice_id,
            'customer_name' => $collection->invoice->customer->shop_name ?? 'Unknown',
            'updated_at' => $collection->updated_at,
        ];
    });

    // Pass data to Blade view
    return view('collection.collections', compact('collections'));
}

    public function CollectionCreate(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0',
            'due' => 'nullable|numeric|min:0',
            // 'invoice_url' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        // Retrieve user_id from the request header or session (make sure it's available)
        $user_id = $request->header('id');  // Ensure this is correctly passed in the headers

        if (!$user_id) {
            return redirect()->back()->withErrors(['user_id' => 'User ID is missing.']);
        }

        $invoice_id = $request->input('invoice_id');
        $amount = $request->input('amount');
        $due = $request->input('due');

        // Check for duplicate invoice_id in the collections table
        $duplicate = Collection::where('invoice_id', $invoice_id)->exists();

        if ($duplicate) {
            // If the invoice_id already exists, return back with an error message
            return redirect()->back()->withErrors(['invoice_id' => 'This invoice has already been processed.']);
        }
        // Create the collection entry in the database
        Collection::create([
            'user_id' => $user_id,
            'invoice_id' => $invoice_id,
            'amount' => $amount,
            'due' => $due,
            // 'invoice_url' => $img_url,
        ]);

        // Return a success response
        return redirect()->back()->with('message', 'Collection amount submitted successfully.');
    }

    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'invoice_id' => 'required|integer|exists:invoices,id',
            'amount' => 'required|numeric|min:0',
            'due' => 'nullable|numeric|min:0',
        ]);

        // Retrieve headers and input data
        $user_id = $request->header('id');
        $collection_id = $request->input('collection_id');

        // Check if the collection exists
        $collection = Collection::findOrFail($collection_id);

        // Update the collection record
        $collection->update([
            'user_id' => $user_id,
            'invoice_id' => $request->input('invoice_id'),
            'amount' => $request->input('amount'),
            'due' => $request->input('due', 0),
        ]);

        // Return a success response
        return redirect()->back()->with('message', 'Collection updated successfully.');
    }


}
