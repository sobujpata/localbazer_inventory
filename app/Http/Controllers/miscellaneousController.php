<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\MiscellaneousCost;
use Illuminate\Http\Client\ResponseSequence;

class miscellaneousController extends Controller
{
    public function OtherCost(){

        return view('pages.dashboard.other-cost');
    }

    public function CostingList(){
        $costs = MiscellaneousCost::with('user')->get();

        return response()->json($costs);

    }

    public function CostingCreate(Request $request)
    {
        // Validate input fields
        $validatedData = $request->validate([
            'recipient' => 'required|string|max:255',
            'reason' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'balance' => 'required|numeric',
        ]);

        try {
            // Retrieve user ID from header
            $user_id = $request->header('id');

            // Ensure user_id is present
            if (!$user_id) {
                return response()->json([
                    'message' => 'User ID is required in headers.'
                ], 400);
            }

            // Create the costing entry
            $costing = MiscellaneousCost::create([
                "recipient" => $validatedData['recipient'],
                "reason" => $validatedData['reason'],
                "amount" => $validatedData['amount'],
                "balance" => $validatedData['balance'],
                "user_id" => $user_id,
            ]);

            // Return a successful response
            return response()->json([
                'message' => 'Costing created successfully',
                'data' => $costing
            ], 201);

        } catch (Exception $e) {
            // Return error message with detailed information
            return response()->json([
                'message' => 'Failed to create costing',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function CostingById(Request $request){
        $id = $request->input('id');

        $costing = MiscellaneousCost::where('id', $id)->first();

        return response()->json($costing);
    }

    public function CostingUpdate(Request $request){
        $id = $request->input('id');

        $updated = MiscellaneousCost::where('id', $id)->update([
            'recipient'=>$request->input('recipient'),
            'reason'=>$request->input('reason'),
            'amount'=>$request->input('amount'),
            'balance'=>$request->input('balance'),
        ]);

        if ($updated) {
            return response()->json(['message' => 'Costing updated with new image'], 200);
        } else {
            return response()->json(['message' => 'Failed to update Costing'], 500);
        }
    }

}
