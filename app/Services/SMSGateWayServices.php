<?php

namespace App\Http\Services;
use App\Models\User_Verfication;



class VerficatoinServices 
{
    /** set OTP code for mobile
     * @param $data
     * 
     * @return VerficationCode
     */
    
    public function setVerficationCode($data){
        $code = mt_rand(100000, 999999);
        $data['code'] = $code;
        User_Verfication::whereNotNull('user_id')->where(['user_id'=>$data['user_id']])->delete();
        
        return User_Verfication::create($data);
    }
    
}
