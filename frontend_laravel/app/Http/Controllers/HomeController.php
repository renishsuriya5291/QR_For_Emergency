<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{
    public function index(Request $request){
        if(Session::get('uid')){
            $token = Session::get('Authorization');
            $uid = Session::get('uid');
            $response = Http::withHeaders([
                'Authorization' =>  $token,
                'Content-Type' => 'application/json',
            ])->get(env('SERVER_PATH').'/api/v0/user/'. $uid .'/qr-code');
    
            $responseJson = $response->json();
            // dd($responseJson);
          
            if ($response->successful()) {
                // Fetch data from the response
                $data = $response->json();
                // Fetch response headers
                $headers = $response->headers();
                Session::put('Authorization',$headers['Authorization'][0]);
                // dd($headers);

                $response = Http::withHeaders([
                    'Authorization' =>  $token,
                    'Content-Type' => 'application/json',
                ])->get(env('SERVER_PATH').'/api/v0/user/'. $uid);
                

                $responseJson = $response->json();
                $user = $responseJson['data'][0];

             
                // Pass data to the view
                return view('pages.home', ['data' => $data,'user'=>$user]);
            } else {
                return redirect("/signin");

                // Handle the error
                $errorMessage = $response->body();
                return view('error', ['message' => $errorMessage]);
            }
        }else{
            return redirect("/signin");
        }
    }
}
