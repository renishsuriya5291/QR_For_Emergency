<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class QRController extends Controller
{
    public function show(Request $request){
   
        $id = $request->route('id');
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->get(env('SERVER_PATH').'/api/v0/qr-code/'. $id);


        $responseJson = $response->json();
        if(isset($responseJson['data']['data'])){
            $QRDetail = $responseJson['data']['data'];
            return view('pages/qr_code', [ 'QRDetail' => $QRDetail]);
        }else{
            return redirect("/");
        }
    }
}
