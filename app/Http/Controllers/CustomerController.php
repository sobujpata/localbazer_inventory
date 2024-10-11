<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{

    function CustomerPage():View{
        return view('pages.dashboard.customer-page');
    }

    function CustomerCreate(Request $request){
        $user_id=$request->header('id');
        return Customer::create([
            'name'=>$request->input('name'),
            'shop_name'=>$request->input('shop_name'),
            'address'=>$request->input('address'),
            'mobile'=>$request->input('mobile'),
            'email'=>$request->input('email'),
            'user_id'=>$user_id
        ]);
    }


    function CustomerList(Request $request){
        $user_role=$request->header('role');
        $customer = Customer::get();

        return response()->json([
            'data' => $customer,
            'role' => $user_role
        ]);
    }


    function CustomerDelete(Request $request){
        $customer_id=$request->input('id');
        $user_id=$request->header('id');
        return Customer::where('id',$customer_id)->delete();
    }


    function CustomerByID(Request $request){
        $customer_id=$request->input('id');
        $user_id=$request->header('id');
        return Customer::where('id',$customer_id)->first();
    }


     function CustomerUpdate(Request $request){
        $customer_id=$request->input('id');
        $user_id=$request->header('id');
        return Customer::where('id',$customer_id)->update([
            'name'=>$request->input('name'),
            'shop_name'=>$request->input('shop_name'),
            'address'=>$request->input('address'),
            'mobile'=>$request->input('mobile'),
            'email'=>$request->input('email'),
        ]);
    }



}
