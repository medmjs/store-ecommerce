<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Product;
use App\Models\Attribute;
use App\Http\Requests\OptionRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OptionController extends Controller {

    public function viewOption() {

       //$options = Option::with(['product','attripute'])->select('id', 'product_id', 'attribute_id', 'price')->paginate(PAGENATION_COUNT);
       $options = Option::with(['product'=> function($query){
           $query->select('id');
       },'attribute'=>function($query){
           $query->select('id');
       }])->select('id', 'product_id', 'attribute_id', 'price')->paginate(PAGENATION_COUNT);
        
        return view('dashboard.products.option.index', compact('options'));
    }

    public function createOption() {
        $data = [];
        $data['product'] = Product::active()->select('id')->get();
        $data['attribute'] = Attribute::select('id')->get();
        return view("dashboard.products.option.create", compact('data'));
    }

    public function saveOption(OptionRequest $req) {


        try {
            DB::beginTransaction();
            $option = Option::create([
                        "product_id" => $req->product,
                        "price" => $req->price,
                        "attribute_id" => $req->attribute
            ]);

            $option->name = $req->name;
            $option->save();
            DB::commit();
            return redirect()->route('admin.Option')->with(['success' => 'تمت اضافة منتج جديد ']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'هنالك خطا ']);
        }
    }

    public function editOption($id) {
        $data = [];
        $option = Option::find($id);
        $data['product'] = Product::active()->select('id')->get();
        $data['attribute'] = Attribute::select('id')->get();
       
        return view('dashboard.products.option.edit', compact('option','data'));
    }

    public function updateOption(OptionRequest $req, $id) {
        try {

            DB::beginTransaction();
            $option = Option::find($id);
            
            $option->update([
                'product_id'=>$req->product,
                'attribute_id'=>$req->attribute,
                'price'=>$req->price,
            ]);
            $option->name = $req->name;
            $option->save();
            DB::commit();

            return redirect()->route('admin.Option')->with(['success' => 'تمت تعديل قيمة خاصيه جديده ']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => 'هنالك خطا ']);
        }
    }

    public function deleteOption($id) {

        try {
            DB::beginTransaction();
            $option = Option::find($id);
            $option->translations[0]->delete();
            $option->delete();
            DB::commit();

            return redirect()->route('admin.Option')->with(['success' => 'تمت حذف قيمة خاصيه  ']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => 'هنالك خطا ']);
        }
    }

}
