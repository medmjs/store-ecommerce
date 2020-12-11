<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use App\Http\Requests\VerifyCodeRequest;
use App\Http\Services\VerificationServices;
use Illuminate\Support\Facades\Auth;

class VerificationCodeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | o
     * mobile Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */
    public $verifyServices;
    
    public function __construct(VerificationServices $verificationServices)
    {
        $this->verifyServices = $verificationServices;
    }

    public function verifyCode(VerifyCodeRequest $req)
    {
        $check = $this->verifyServices->checkOTPCode($req->code);
        if(!$check){//not correct Code
            return redirect()->route('verify')->withErrors(['code'=>'not correct code']);//.Auth::id();
        }else{ //not correct Code
            $this->verifyServices->removeOTPCode($req->code);
            return redirect()->route('profile');
        }
        
    }
    
    
    
    public function verify(){
        return view('auth.verification');
    }
    

}
