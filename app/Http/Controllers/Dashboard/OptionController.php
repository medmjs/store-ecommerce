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

    public function editAttribute($id) {
        $attribute = Attribute::find($id);
        return view('dashboard.products.attribute.edit', compact('attribute'));
    }

    public function updateAttribute(AttributeRequest $req, $id) {
        try {

            DB::beginTransaction();
            $attribute = Attribute::find($id);
            $attribute->name = $req->name;
            $attribute->save();
            DB::commit();

            return redirect()->route('admin.products.attribute')->with(['success' => 'تمت تعديل خاصيه جديده ']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => 'هنالك خطا ']);
        }
    }

    public function deleteAttribute($id) {

        try {
            DB::beginTransaction();
            $attribute = Attribute::find($id);
            $attribute->translations[0]->delete();
            $attribute->delete();
            DB::commit();

            return redirect()->route('admin.products.attribute')->with(['success' => 'تمت حذف خاصيه  ']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['error' => 'هنالك خطا ']);
        }
    }

}
