<?php

namespace App\Http\Controllers;

use App\Models\BuyProduct;
use Illuminate\Http\Request;
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

    public function buyingDetails(){
        $data = BuyProduct::get();

        return $data;
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
        $buyProduct = BuyProduct::find($id);

        return response()->json([
            'data' =>$buyProduct
        ]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
