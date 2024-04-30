<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class SessionController extends Controller
{
    public function update(Request $request)
    {
        $value = $request->input('value');
        session(['Authorization' => $value]); // Set session value using session() helper
    
        // Check if the session value is properly set
        if (session()->has('Authorization')) {
            return response()->json(['message' => 'Session updated successfully']);
        } else {
            return response()->json(['message' => 'Failed to update session'], 500);
        }
    }
}
