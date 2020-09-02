<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use phpDocumentor\Reflection\DocBlock\Tags\See;
use App\Http\Requests\ShippingRequest;

class SittingsController extends Controller
{
    //

    public function editShippingMethods($type)
    {

        $shippingMethod = null;
        if ($type === 'free') {
            $shippingMethod = Setting::where('key', 'free_shipping_label')->first();
        } elseif ($type === 'inner') {
            $shippingMethod = Setting::where('key', 'local_label')->first();
        } elseif ($type === 'outer') {
            $shippingMethod = Setting::where('key', 'outer_label')->first();
        } else
            $shippingMethod = Setting::where('key', 'free_shipping_label')->first();


        return view('dashboard.settings.shippings.edit',compact('shippingMethod'));
        //return $shippingMethod;
    }
    public function updateShippingMethods(ShippingRequest $req,$id){

        //validation





        //update



        return $req ;

    }
}
