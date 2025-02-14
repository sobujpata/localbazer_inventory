<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\LoanRepayBalance;
use Illuminate\Http\Request;

class BankLoanController extends Controller
{
    public function Banks(){
        return view("pages.dashboard.banks");
    }
    public function LoanRepayPage(){
        return view("pages.dashboard.bank-balance");
    }

    public function BankList(){
        $data = Bank::all();

        return response()->json($data);
    }
    public function BankLoanById(Request $request, $id){
        $data = Bank::find($id); // Fetch data based on ID

        return response()->json($data);
    }

    public function BankCreate(Request $request){
        $bank_name = $request->input('bank_name');
        $loan_type = $request->input('loan_type');
        $loan_amount = $request->input('loan_amount');
        $total_repay_amount = $request->input('total_repay_amount');
        $total_installment = $request->input('total_installment');

        Bank::create([
            'bank_name'=>$bank_name,
            'loan_type'=>$loan_type,
            'loan_amount'=>$loan_amount,
            'total_repay_amount'=>$total_repay_amount,
            'total_installment'=>$total_installment,
        ]);

        return response()->json([
            'status'=>'success',
            'message'=>'Bank created successfully.'
        ],201);
    }

    public function LoanRepayList(){
        $data = LoanRepayBalance::with('banks')->with('user')->get();

        return response()->json($data);
    }

    public function LoanRepayCreate(Request $request)
    {
        // Validate request data
        $request->validate([
            'loan_type' => 'required|exists:banks,id',
            'total_installment' => 'required|numeric|min:1',
        ]);

        $user_id = $request->header('id');
        $loan_type = $request->input('loan_type');
        $total_installment = $request->input('total_installment');

        // Find the loan and check if it exists
        $loan = Bank::find($loan_type);
        if (!$loan) {
            return response()->json([
                'status' => "error",
                'message' => "Loan type not found."
            ], 404);
        }

        $total_repay_amount = $loan->total_repay_amount;

        // Get previous payments
        $previous_total_pay = LoanRepayBalance::where('bank_id', $loan_type)->sum('pay_amount');
        $payment_count = LoanRepayBalance::where('bank_id', $loan_type)->count();
        
        // Calculate new total pay and balance
        $total_pay = $previous_total_pay + $total_installment;
        $balance = $total_repay_amount - $total_pay;


        // Store the new installment payment
        LoanRepayBalance::create([
            'user_id' => $user_id,
            'bank_id' => $loan_type, // Ensure the bank_id is saved
            'installment_no' => $payment_count + 1,
            'pay_amount' => $total_installment,
            'total_pay' => $total_pay,
            'balance' => $balance
        ]);

        return response()->json([
            'status' => "success",
            'message' => "Installment paid successfully."
        ], 201);
    }

}
