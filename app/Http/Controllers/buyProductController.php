<?php

namespace App\Http\Controllers;

use App\Models\BuyProduct;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Facades\File;


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
        $user_id = $request->header('id');

        // Prepare File Name & Path
        $img=$request->file('invoice_url');

        $t=time();
        $file_name=$img->getClientOriginalName();
        $img_name="{$user_id}-{$t}-{$file_name}";
        $img_url="buyingInvoice/{$img_name}";


        // Upload File
        $img->move(public_path('buyingInvoice'),$img_name);


        // Save To Database
        return BuyProduct::create([
            'user_id'=>$user_id,
            'category_id'=>$request->input('category_id'),
            'product_cost'=>$request->input('product_cost'),
            'other_cost'=>$request->input('other_cost'),
            'invoice_url'=>$img_url,

        ]);
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
