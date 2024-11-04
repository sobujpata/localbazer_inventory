<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\MiscellaneousCost;

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

}
