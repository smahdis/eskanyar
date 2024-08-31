<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Laravel\Message\KavenegarMessage;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sms', function () {

    try{
        $receptor =  "09150798805";
        $template =  "khadem";
        $type =  "sms";
        $token =  "بهجت";
        $token2 =  "09365609231";
        $token3 =  "";
        $result = Kavenegar::VerifyLookup($receptor,$token,$token2,$token3,$template,$type);
        echo "<pre>";
        foreach($result as $r){
            echo "messageid => " . $r->messageid;
            echo "message => " . $r->message;
            echo "status => " . $r->status;
            echo "statustext => " . $r->statustext;
            echo "sender => " . $r->sender;
            echo "receptor => " . $r->receptor;
            echo "date => " . $r->date;
            echo "cost => " . $r->cost;
            echo "<hr/>";
        }
        echo "</pre>";


//        $this->format($result);
    }
    catch(ApiException $e){
        echo $e->errorMessage();
    }
    catch(HttpException $e){
        echo $e->errorMessage();
    }



});


//Route::get('/', function () {
//    return view('index');
//});

Route::get('logout', function () {
    Auth::logout();
    return redirect()->back();
});
