<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use phpDocumentor\Reflection\DocBlock\Tags\See;
use App\Http\Requests\ShippingRequest;
use DB;

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



        try {
            //update
            $shipping_method =Setting::find($id);

            DB::beginTransaction();
            $shipping_method->update(['plain_value'=>$req-> plain_value]);

            //update translations

            $shipping_method->value = $req->value;

            $shipping_method->save();

            DB::commit();

            return redirect()->back()->with(['success'=>'Update Done ']);

        }catch (\Exception $ex){
            DB::rollbak();
            return redirect()->back()->with(['error'=>'هنالك خطا ما يرجى المحاوله ']);


        }



    }
}
