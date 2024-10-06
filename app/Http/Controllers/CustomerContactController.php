<?php

namespace App\Http\Controllers;

use App\Models\Message;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerContactController extends Controller
{
    public function CustomerContactUs(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Create a new message entry
        $data = Message::create($validatedData);

        return response()->json(['message' => 'Message sent successfully'], 200);
    }
}
