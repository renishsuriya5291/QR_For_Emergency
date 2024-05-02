<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    public function index(Request $request){
        $token = Session::get('Authorization');
        $uid = Session::get('uid');
        $response = Http::withHeaders([
            'Authorization' =>  $token,
            'Content-Type' => 'application/json',
        ])->get(env('SERVER_PATH').'/api/v0/user/'. $uid);
        

        $responseJson = $response->json();
        $user = $responseJson['data'][0];

        return view('pages.profile', compact('user'));
    }

    public function updateProfile(Request $request){
        $token = Session::get('Authorization');
        $uid = Session::get('uid');
        $fullName = $request->input("fullName");
        $phoneNo = $request->input("phoneNo");
        
        // Handling file upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $extension = $photo->getClientOriginalExtension(); // Get file extension
            $fileName = time() . '_'. $phoneNo . '.' . $extension; // Append timestamp to filename
            $photo->move(public_path('images'), $fileName);
        } else {
            $fileName = ''; 
        }
    
        $response = Http::withHeaders([
            'Authorization' =>  $token,
            'Content-Type' => 'application/json',
        ])->put(env('SERVER_PATH').'/api/v0/user/'. $uid, [
            'fullName' => $fullName,
            'phoneNo' => $phoneNo,
            'photo' => $fileName, 
        ]);
    
        $responseJson = $response->json();
        // dd($responseJson);
      
        if ($response->successful()) {
            return response()->json(['success' => true, 'url' => $fileName]);
        } else {
            return response()->json(['success' => false]);
        }
        
    }
}
