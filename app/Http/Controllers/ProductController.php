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
        return Product::where('id',$product_id)->where('user_id',$user_id)->delete();

    }


    function ProductByID(Request $request)
    {
        $user_id=$request->header('id');
        $product_id=$request->input('id');
        return Product::where('id',$product_id)->where('user_id',$user_id)->first();
    }


    function ProductList(Request $request)
    {
        $user_id=$request->header('id');
        return Product::where('user_id',$user_id)->get();
    }




    function UpdateProduct(Request $request)
    {
        $user_id=$request->header('id');
        $product_id=$request->input('id');

        if ($request->hasFile('img')) {

            // Upload New File
            $img=$request->file('img');
            $t=time();
            $file_name=$img->getClientOriginalName();
            $img_name="{$user_id}-{$t}-{$file_name}";
            $img_url="uploads/{$img_name}";
            $img->move(public_path('uploads'),$img_name);

            // Delete Old File
            $filePath=$request->input('file_path');
            File::delete($filePath);

            // Update Product

            return Product::where('id',$product_id)->where('user_id',$user_id)->update([
                'name'=>$request->input('name'),
                'buy_price'=>$request->input('buy_price'),
                'wholesale_price'=>$request->input('wholesale_price'),
                'buy_qty'=>$request->input('buy_qty'),
                'img_url'=>$img_url,
                'category_id'=>$request->input('category_id')
            ]);

        }

        else {
            return Product::where('id',$product_id)->where('user_id',$user_id)->update([
                'name'=>$request->input('name'),
                'buy_price'=>$request->input('buy_price'),
                'wholesale_price'=>$request->input('wholesale_price'),~
                'buy_qty'=>$request->input('buy_qty'),
                'category_id'=>$request->input('category_id'),
            ]);
        }
    }
}
