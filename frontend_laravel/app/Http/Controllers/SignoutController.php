<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;



class SignoutController extends Controller
{
    public function signout(Request $request){
        $authToken = Session::get('Authorization');
        
        $response = Http::post(env("SERVER_PATH").'/api/v0/auth/signout');
           
        // Check if the request was successful
        $responsedata = $response->json();
        Session::put('Authorization', null);
        Session::put('name', null);
        Session::put('uid', null);
        return redirect("/signin");

    }
}
