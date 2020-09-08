<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //

    public function editProfile(){

        $id = auth('admin')->user()->id;

        $user = Admin::find($id);

        return view('dashboard.profile.edit',compact('user'));
    }

    public function updateProfile(ProfileRequest $req){

        //validation

        //update


        try {
            $user = Admin::find($req->id);

            if($req->filled('password')){
                $req->merge(['password'=>bcrypt($req->password)]);
                $user->update(['name'=>$req->userName,'email'=>$req->email,'password'=>$req->password]);
            }
            else{
                $user->update(['name'=>$req->userName,'email'=>$req->email]);
            }
                         
            $user->save();
            return redirect()->back()->with(['success'=>'تمت العمليه بالنجاح']);

        }catch (\Exception $ex){

        }



    }


}
