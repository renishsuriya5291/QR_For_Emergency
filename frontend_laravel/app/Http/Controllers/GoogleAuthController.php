<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request){
        try {
            $google_user = Socialite::driver('google')->user();

            $data = [
                'email' => $google_user->email,
                'uid' => $google_user->id,
                'fullName' => $google_user->name
            ];
            
            // Make the API request
            $response = Http::post(env("SERVER_PATH").'/api/v0/auth/signup', $data);
           
            // Check if the request was successful
            $responsedata = $response->json();
            $ipAddress = $request->ip();

            // Get client's user agent
            $userAgent = $request->header('User-Agent');
            
            if ($response->successful()) {
                $signindata = [
                    'ipAddress' => $ipAddress,
                    'userAgent' => $userAgent,
                    'uid' => $google_user->id
                ];
                  
                $responseSignIn = Http::post(env("SERVER_PATH").'/api/v0/auth/signin', $signindata);
                $responsedata1 = $responseSignIn->json();

                $headers = $responseSignIn->headers();
                Session::put('Authorization',$headers['Authorization'][0]);
                Session::put('name',$google_user->name);
                Session::put('uid',$google_user->id);

                return redirect("/");
            } else {
                // If the request was not successful
                if ($response->status() === 422) {
                    // dd($responsedata['error']);
                    // please call signin api here. 
                    $signindata = [
                        'ipAddress' => $ipAddress,
                        'userAgent' => $userAgent,
                        'uid' => $google_user->id
                    ];
                    
                    $responseSignIn = Http::post(env("SERVER_PATH").'/api/v0/auth/signin', $signindata);
                    $responsedata1 = $responseSignIn->json();
                    // Fetch response headers
                    $headers = $responseSignIn->headers();
                    Session::put('Authorization',$headers['Authorization'][0]);
                    Session::put('name',$google_user->name);
                    Session::put('uid',$google_user->id);
                    // dd($headers['Authorization'][0]);
                    return redirect("/");
                }
                // Handle other errors
            }
        } catch(\Exception $e) {
            dd("Something went wrong..." . $e->getMessage());
        }
        
    }


    
}
