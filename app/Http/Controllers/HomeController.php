<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function HomePage(){
        return view('pages.home');
    }
    function Testmonial(){
        return view('pages.Home-page.partner');
    }
    function Contact(){
        return view('pages.Home-page.contacts');
    }
    public function HomeProduct(Request $request)
    {
        // Start with an available cars/products query
        $query = Product::query();

        // Apply filter by car type if selected
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Apply filter by product name (Bangla name) if selected
        if ($request->has('name') && $request->name != '') {
            $query->where('name', $request->name);
        }

        // Apply filter by product English name if selected
        if ($request->has('eng_name') && $request->eng_name != '') {
            $query->where('eng_name', $request->eng_name);
        }

        // Get the filtered list of products and paginate the results
        $products = $query->paginate(10);  // Paginate with 10 items per page

        // Get distinct categories, names, and English names for filter options
        $categorys = Category::select('id','name')->get();


        // Pass the filtered products, filter options, and request data to the view
        return view('pages.Home-page.products', compact('products', 'categorys', 'request'));
    }

}
