<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages/home');
});


Route::get('/signin', function () {
    return view('pages/signin');
});

Route::get('/signup', function () {
    return view('pages/signup');
});

Route::get('/groups', function () {
    return view('pages/group');
});
Route::get('/create_qr_form', function () {
    return view('components/create_qr_form');
});
Route::get('/create_group_form', function () {
    return view('components/create_group_form');
});
Route::get('/add_member_form', function () {
    return view('components/add_member_form');
});
Route::get('/group_details', function () {
    return view('components/group_details');
});





