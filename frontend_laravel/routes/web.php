<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\FacebookAuthController;
use App\Http\Controllers\SignoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\QRController;

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

Route::get('/', [HomeController::class, 'index']);


Route::get('/signin', function () {
    return view('pages/signin');
});

Route::get('/signup', function () {
    return view('pages/signup');
});

Route::get('/groups', [GroupController::class, 'index']);

Route::get('/create_qr_form', function () {
    return view('components/create_qr_form');
});
Route::get('/update_qr_form', function () {
    return view('components/update_qr_form');
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

Route::get('/signout', [SignoutController::class, 'signout']);

Route::post('/update-session', [SessionController::class, 'update']);

Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google-auth');
Route::get('/auth/google/call-back', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google-auth-callback');

Route::get('/auth/facebook', [FacebookAuthController::class, 'redirectToFacebook'])->name('facebook-auth');
Route::get('/auth/facebook/call-back', [FacebookAuthController::class, 'handleFacebookCallback']);


