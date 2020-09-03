<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginValidation;


class LoginController extends Controller
{
    public function loginView(){
        return view('dashboard.auth.login');
    }

    public function login(AdminLoginValidation $req){
        //validation

        //chick in database

        $remember_me = $req->has('remember_me') ? true : false;

        if(auth()->guard('admin')->attempt(['email'=>$req->input('email'),'password'=>$req->input('password')])){
            return redirect()->route('admin.dashboard');
        }
        else
            return redirect()->back()->with(['error'=>'هذا الأدمن غير موجود']);


    }

    public function logout(){
        $gaurd =$this ->getGaurd();
        $gaurd->logout();
        return redirect()->route('admin.login');
    }
    public function getGaurd(){
        return auth('admin');
    }


}
