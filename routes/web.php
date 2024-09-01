<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Laravel\Message\KavenegarMessage;

Route::get('/', function () {
//    return view('welcome');
    return Redirect::to('/admin');
});



//Route::get('/', function () {
//    return view('index');
//});

Route::get('logout', function () {
    Auth::logout();
    return redirect()->back();
});
