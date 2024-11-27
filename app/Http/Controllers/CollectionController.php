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
            'customer_address' => $collection->invoice->customer->address ?? 'Unknown',
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
        $customer_id = Invoice::where('id', $invoice_id)->select('customer_id')->first();
        // Create the collection entry in the database
        Collection::create([
            'user_id' => $user_id,
            'invoice_id' => $invoice_id,
            'amount' => $amount,
            'due' => $due,
            'customer_id' => $customer_id,
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
        'collection_id' => 'required|integer|exists:collections,id',
        'amount' => 'required|numeric|min:0',
        'due' => 'nullable|numeric|min:0',
    ]);

    // Retrieve headers and input data
    $user_id = $request->header('id');
    $collection_id = $request->input('collection_id');

    // Fetch the customer ID from the invoice
    $invoice = Invoice::find($request->input('invoice_id'));
    if (!$invoice) {
        return response()->json(['error' => 'Invoice not found'], 404);
    }
    $customer_id = $invoice->customer_id;

    // Find the collection and update its data
    $collection = Collection::findOrFail($collection_id);
    $collection->update([
        'user_id' => $user_id,
        'invoice_id' => $request->input('invoice_id'),
        'amount' => $request->input('amount'),
        'due' => $request->input('due', 0),
        'customer_id' => $customer_id,
    ]);

    // Return a JSON response with the updated collection
    return redirect()->back()->with('message', "Collaction Update Successfully.");
}


    public function DueList(Request $request){
        // Fetch collections where due is not zero and order by descending
            $query = Collection::with('invoice.customer')
            ->where('due', '!=', 0)
            ->orderBy('created_at', 'desc');

        // Apply filter by search input for invoice_id if provided
        if ($request->filled('invoice_id')) {
        $query->where('invoice_id', $request->invoice_id);
        }

        // Get paginated and mapped data
        $collections = $query->paginate(16)->through(function ($collection) {
        return [
            'collection_id' => $collection->id,
            'amount' => $collection->amount,
            'due' => $collection->due,
            'invoice_id' => $collection->invoice_id,
            'customer_name' => $collection->invoice->customer->shop_name ?? 'Unknown',
            'customer_address' => $collection->invoice->customer->address ?? 'Unknown',
            'updated_at' => $collection->updated_at,
            ];
        });

        // Pass data to Blade view
        return view('collection.due-amount', compact('collections'));
    }

    public function DueUpdate(Request $request){
        // Validate the request data
        $request->validate([
            'invoice_id' => 'required|integer|exists:invoices,id',
            'amount' => 'required|numeric|min:0',
            'due' => 'required|numeric|min:0',
            'if_due' => 'nullable|numeric|min:0',
        ]);

        // Retrieve headers and input data
        $user_id = $request->header('id');
        $collection_id = $request->input('collection_id');

        // Check if the collection exists
        $collection = Collection::findOrFail($collection_id);

        $old_amount = $request->input('amount');
        $due_amount = $request->input('due');
        $if_due = $request->input('if_due');
        $new_amount = $collection->amount + $due_amount;
        $new_due = 0.00 + $if_due;

        // Update the collection record
        $collection->update([
            'user_id' => $user_id,
            'invoice_id' => $request->input('invoice_id'),
            'amount' => $new_amount,
            'due' => $new_due,
        ]);

        // Return a success response
        return redirect()->back()->with('message', 'Collection updated successfully.');
    }


}
