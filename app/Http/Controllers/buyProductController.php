<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Partner;
use App\Models\BuyProduct;
use App\Models\Collection;
use Illuminate\Http\Request;
use App\Models\MiscellaneousCost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Symfony\Contracts\Service\Attribute\Required;


class buyProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.dashboard.buy-product-page');
    }

    public function buyingDetails(Request $request){
        $user_role = $request->header('role');
        $data = BuyProduct::with('category')->get();

        return response()->json([
            'role'=>$user_role,
            'data'=>$data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate Request Data
        $request->validate([
            'category_id' => 'required|integer',
            'product_cost' => 'required|numeric',
            'shop_name' => 'required|string',
            'invoice_url' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5000', // Adjust file types and max size as needed
        ]);

        // Calculate Collection, Total Deposit, Product Cost, and Balance
        $collection = Collection::sum('amount');
        $total_deposit = Partner::sum('amount');
        $total_deposit_with_collection = $total_deposit + $collection;
        $product_cost = $request->input('product_cost');
        $total_miscellanious_cost = MiscellaneousCost::sum('amount') + $product_cost;
        $balance = $total_deposit_with_collection - $total_miscellanious_cost;

        // Get User ID from Request Header
        $user_id = $request->header('id');

        // Handle File Upload
        if ($request->hasFile('invoice_url')) {
            $img = $request->file('invoice_url');
            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$user_id}-{$t}-{$file_name}";
            $img_url = "buyingInvoice/{$img_name}";

            // Upload File
            $img->move(public_path('buyingInvoice'), $img_name);
        } else {
            return response()->json(['error' => 'Invoice file is required'], 400);
        }

        DB::beginTransaction();
        try {
            // Save to Database
            BuyProduct::create([
                'user_id' => $user_id,
                'category_id' => $request->input('category_id'),
                'product_cost' => $product_cost,
                'other_cost' => 0,
                'invoice_url' => $img_url,
            ]);

            // Create the costing entry
            MiscellaneousCost::create([
                'recipient' => $request->input('shop_name'),
                'reason' => 'Buying',
                'amount' => $product_cost,
                'balance' => $balance,
                'user_id' => $user_id,
            ]);

            DB::commit();
            return response()->json(['success' => 'Product purchase recorded successfully'], 201);
        } catch (Exception $e) {
            DB::rollBack();
            // Log the error for debugging
            Log::error("Error in store function: " . $e->getMessage());
            return response()->json(['error' => 'Failed to record product purchase'], 500);
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $id = $request->input('id');
        return BuyProduct::where('id',$id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // Validate input data
    $validatedData = $request->validate([
        'category_id' => 'required|integer',
        'product_cost' => 'required|string|max:255',
        'other_cost' => 'required|string|max:255',
        'invoice_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    $product_id = $id; // Assuming $id is validated as a string

    $user_id = $request->header('id');

    if ($request->hasFile('invoice_url')) {
        // Upload new file securely
        $img = $request->file('invoice_url');
        $t = time();
        $file_name = $img->getClientOriginalName();
        $img_name = "{$user_id}-{$t}-{$file_name}";
        $img_url = "buyingInvoice/{$img_name}";

        // Upload File
        $img->move(public_path('buyingInvoice'), $img_name); // Store in public disk

        // Delete old file if it exists
        $filePath = $request->input('file_path');
        if ($filePath && File::exists(public_path($filePath))) {
            File::delete(public_path($filePath));
        }

        // Update product with new image
        $updated = BuyProduct::where('id', $product_id)->update([
            'product_cost' => $request->input('product_cost'),
            'other_cost' => $request->input('other_cost'),
            'invoice_url' => $img_url,
            'category_id' => $request->input('category_id'),
        ]);

        if ($updated) {
            return response()->json(['message' => 'Buy Product updated with new image'], 200);
        } else {
            return response()->json(['message' => 'Failed to update Buy product'], 500);
        }
    }

    // Update product without image
    $updated = BuyProduct::where('id', $product_id)->update([
        'product_cost' => $request->input('product_cost'),
        'other_cost' => $request->input('other_cost'),
        'category_id' => $request->input('category_id'),
    ]);

    if ($updated) {
        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully'
        ], 200);
    } else {
        return response()->json(['message' => 'Failed to update product'], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user_id=$request->header('id');
        $buy_id=$request->input('id');
        $filePath=$request->input('file_path');
        File::delete($filePath);
        return BuyProduct::where('id',$buy_id)->delete();
    }
}
