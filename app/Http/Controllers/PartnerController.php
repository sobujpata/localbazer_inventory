<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index(){
        $partners = Partner::with('user')->get();
        return view('pages.dashboard.partners', compact('partners'));
    }

    public function DepositAmount(Request $request){
        $id = $request->input('id');
        $old_amount = $request->input('old_amount');
        $deposit_amount = $request->input('amount');

        $update_amount = $old_amount + $deposit_amount;
        Partner::where('id', $id)->update(['amount'=>$update_amount]);

        return redirect()->back()->with('success', 'Deposit amount submitted successfully');
    }
    public function WithdrawAmount(Request $request){
        $id = $request->input('id');
        $old_amount = $request->input('old_amount');
        $deposit_amount = $request->input('amount');

        $update_amount = $old_amount + $deposit_amount;
        Partner::where('id', $id)->update(['withdraw_amount'=>$update_amount]);
        return redirect()->back()->with('success', 'Withdraw amount submitted successfully');
    }
}
