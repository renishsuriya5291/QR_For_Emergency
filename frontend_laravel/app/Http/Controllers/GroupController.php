<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;



class GroupController extends Controller
{
    // public function index(Request $request){
    //     if(Session::get('uid')){
    //         return view('pages.group');
    //     }else{
    //         return redirect("/signin");
    //     }
    // }

    public function index(Request $request){
        if(Session::get('uid')){
            $token = Session::get('Authorization');
            $uid = Session::get('uid');
            $response = Http::withHeaders([
                'Authorization' =>  $token,
                'Content-Type' => 'application/json',
            ])->get(env('SERVER_PATH').'/api/v0/user/'. $uid .'/family-group');
            
    
            $responseJson = $response->json();
            // dd($responseJson);
          
            if ($response->successful()) {
                // Fetch data from the response
                $data = $response->json();
                // Fetch response headers
                $headers = $response->headers();
                Session::put('Authorization',$headers['Authorization'][0]);
                // dd($headers);
             
                // Pass data to the view
                return view('pages.group', ['data' => $data]);
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
