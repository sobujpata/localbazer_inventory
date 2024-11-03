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
        ]);

        try {
            $user_id = $request->header('id');

            $costing = MiscellaneousCost::create([
                "recipient" => $validatedData['recipient'],
                "reason" => $validatedData['reason'],
                "amount" => $validatedData['amount'],
                "user_id" => $user_id,
            ]);

            return response()->json([
                'message' => 'Costing created successfully',
                'data' => $costing
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create costing',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
