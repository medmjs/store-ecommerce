<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandsController extends Controller
{

    public function index()
    {

        $brand = Brand::orderBy('id','DESC')->paginate(PAGENATION_COUNT);
        return view('dashboard.brands.index',compact('brand'));
    }
    public function create()
    {
        return view('dashboard.brands.create');
    }

    public function store(BrandRequest $req)
    {
        if(!$req->has('is_active'))
            $req->request->add(['is_active' => 0]);
        else
            $req->request->add(['is_active' => 1]);

        $fileName =null;
        if($req->has('photo')){
            $fileName = uploadImage('brands',$req->photo);
        }

        try {
            DB::beginTransaction();
            $brand = Brand::create(['is_active'=>$req->is_active,'photo'=>$fileName]);
            $brand->name = $req->name;
            $brand->save();
            DB::commit();
            return redirect()->route('admin.brands')->with(['success'=>'تمت العنليه بنجاح']);

        }catch (\Exception $ex){

            DB::rollBack();
        }



    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        return view('dashboard.brands.edit',compact('brand'));

    }

    public function update($id, BrandRequest $req)
    {
        try {
        if(!$req->has('is_active'))
            $req->request->add(['is_active'=>0]);
        else
            $req->request->add(['is_active'=>1]);

        $fileName ='';
        if($req->has('photo')){
            $fileName = uploadImage('brands',$req->photo);
        }

        $brnad = Brand::find($id);
        $brnad->update(['is_active'=>$req->is_active,'photo'=>$fileName]);
        $brnad->name = $req->name;
        $brnad->save();

        return redirect()->route('admin.brands')->with(['success'=>'مت العمليه بالنجاح']);
        }catch (\Exception $ex){


        }



    }

    public function delete($id)
    {
        try {

            $brand = Brand::find($id);
            $action = $brand->delete();
            if($action == 1 )
                return redirect()->route('admin.brands')->with(['success'=>'تم حذف العنصر']);
            else
                return redirect()->route('admin.brands')->with(['error'=>'هنالك خطاء']);
        }catch (\Exception $ex){

    }

    }

    public function changeStatus()
    {

    }

}
