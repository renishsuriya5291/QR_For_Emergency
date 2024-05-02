<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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
}
