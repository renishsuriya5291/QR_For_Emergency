<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class GroupController extends Controller
{
    public function index(Request $request){
        if(Session::get('uid')){
            return view('pages.group');
        }else{
            return redirect("/signin");
        }
    }
}
