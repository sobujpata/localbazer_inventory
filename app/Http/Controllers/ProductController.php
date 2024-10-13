<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class ProductController extends Controller
{


    function ProductPage():View{
        return view('pages.dashboard.product-page');
    }


    function CreateProduct(Request $request)
    {
        $user_id=$request->header('id');

        // Prepare File Name & Path
        $img=$request->file('img');

        $t=time();
        $file_name=$img->getClientOriginalName();
        $img_name="{$user_id}-{$t}-{$file_name}";
        $img_url="uploads/{$img_name}";


        // Upload File
        $img->move(public_path('uploads'),$img_name);


        // Save To Database
        return Product::create([
            'name'=>$request->input('name'),
            'eng_name'=>$request->input('eng_name'),
            'buy_price'=>$request->input('buy_price'),
            'buy_qty'=>$request->input('buy_qty'),
            'wholesale_price'=>$request->input('wholesale_price'),
            'img_url'=>$img_url,
            'category_id'=>$request->input('category_id'),
            'user_id'=>$user_id
        ]);
    }


    function DeleteProduct(Request $request)
    {
        $user_id=$request->header('id');
        $product_id=$request->input('id');
        $filePath=$request->input('file_path');
        File::delete($filePath);
        return Product::where('id',$product_id)->delete();

    }


    function ProductByID(Request $request)
    {
        $user_id=$request->header('id');
        $product_id=$request->input('id');
        return Product::where('id',$product_id)->first();
    }


    function ProductList(Request $request)
    {
        $user_role=$request->header('role');
        $product = Product::get();

        return response()->json([
            'data' => $product,
            'role' => $user_role,
        ]);
    }



    public function UpdateProduct(Request $request)
    {
        // Validate input data
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'eng_name' => 'required|string|max:255',
            'buy_price' => 'required|numeric',
            'buy_qty' => 'required|integer',
            'wholesale_price' => 'required|numeric',
            'category_id' => 'required|integer',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure image validation
        ]);
    
        $user_id = $request->header('id');
        $product_id = $request->input('id');
    
        if ($request->hasFile('img')) {
            // Upload new file securely
            $img = $request->file('img');
            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$user_id}-{$t}-{$file_name}";
            $img_url="uploads/{$img_name}";


        // Upload File
        $img->move(public_path('uploads'),$img_name); // Store in public disk
    
            // Delete old file if it exists
            $filePath = $request->input('file_path');
            if (File::exists(public_path($filePath))) {
                File::delete(public_path($filePath));
            }
    
            // Update product with new image
            $updated = Product::where('id', $product_id)->update([
                'name' => $request->input('name'),
                'eng_name' => $request->input('eng_name'),
                'buy_price' => $request->input('buy_price'),
                'buy_qty' => $request->input('buy_qty'),
                'wholesale_price' => $request->input('wholesale_price'),
                'img_url' => $img_url,
                'category_id' => $request->input('category_id'),
            ]);
    
            if ($updated) {
                return response()->json(['message' => 'Product updated with new image'], 200);
            } else {
                return response()->json(['message' => 'Failed to update product'], 500);
            }
        }
    
        // Update product without image
        $updated = Product::where('id', $product_id)->update([
            'name' => $request->input('name'),
            'eng_name' => $request->input('eng_name'),
            'buy_price' => $request->input('buy_price'),
            'buy_qty' => $request->input('buy_qty'),
            'wholesale_price' => $request->input('wholesale_price'),
            'category_id' => $request->input('category_id'),
        ]);
    
        if ($updated) {
            return response()->json([
                'status'=>'success',
                'message' => 'Product updated successfully'
            ], 200);
        } else {
            return response()->json(['message' => 'Failed to update product'], 500);
        }
    }
    
}
