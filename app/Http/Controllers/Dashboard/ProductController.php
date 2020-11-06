<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductPriceRequest;
use App\Http\Requests\ProductStockRequest;
use App\Http\Requests\ProductImageRequest;
use App\Http\Requests\AttributeRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller {

    public function index() {
        $products = Product::select('id', 'slug', 'price', 'is_active', 'created_at')->paginate(PAGENATION_COUNT);
        return view('dashboard.products.general.index', compact('products'));
    }

    public function create() {
        $data = [];
        $data['brands'] = Brand::active()->select('id')->get();
        $data['tags'] = Tag::select('id')->get();
        $data['category'] = Category::active()->select('id')->get();

        return view('dashboard.products.general.create', compact('data'));
    }

    public function store(ProductRequest $req) {


        if (!$req->has('is_active'))
            $req->request->add(['is_active' => 0]);
        else
            $req->request->add(['is_active' => 1]);
        try {

            DB::beginTransaction();
            $prduct = Product::create([
                        'slug' => $req->slug,
                        'brand_id' => $req->brand,
                        'is_active' => $req->is_active,
            ]);
            $prduct->name = $req->name;
            $prduct->description = $req->description;
            $prduct->short_description = $req->short_description;

            $prduct->save();

            $prduct->categories()->attach($req->categories);
            $prduct->tags()->attach($req->tag);
            DB::commit();
            return redirect()->route('admin.products.general.create')->with(['success' => 'تمت اضافة منتج جديد ']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'هنالك خطا ']);
        }
    }

    public function getPrice($id) {
        return view('dashboard.products.price.create', compact('id'));
    }

    public function storePrice(ProductPriceRequest $req) {
        try {

            Product::whereId($req->product_id)->update($req->only(['price', 'special_price', 'special_price_type', 'special_price_start', 'special_price_end']));



            return redirect()->route('admin.products')->with(['success' => 'تمت اضافة منتج جديد ']);
        } catch (\Exception $e) {
            
        }
    }

    public function getStock($id) {
        // $product = Product::whereId($id)->select('sku','manage_stock','in_stock','qty')->get();
        $product = Product::find($id);

        return view('dashboard.products.Stock.create', compact('product'));
    }

    public function storeStock(ProductStockRequest $req) {
        try {


            //Product::whereId($req->product_id)->update($req->only(['sku','manage_stock','in_stock','qty']));
            Product::whereId($req->product_id)->update($req->except(['_token', 'product_id']));



            return redirect()->route('admin.products')->with(['success' => 'تمت اضافة منتج جديد ']);
        } catch (\Exception $e) {
            
        }
    }

    public function getImages($id) {

        return view('dashboard.products.image.create')->withId($id);
    }

    public function saveProductImages(Request $request ){

        return $request;
        $file = $request->file('dzfile');
        $filename = uploadImage('products', $file);

        return response()->json([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);

    }
    
    public function saveProductImagesDB(Request $req){
        return $req;
    }
    
    
    public function viewAttribute(){
        
        $atrribute = Attribute::orderBy('id','DESC')->paginate(PAGENATION_COUNT);
        return view('dashboard.products.attribute.index', compact('atrribute'));
    }
    
    public function createAttribute(){
        return view("dashboard.products.attribute.create");
    }
    
    public function saveAttribute(AttributeRequest $req){
        
        try{
            DB::beginTransaction();
        $attribute = Attribute::create();
        $attribute ->name =$req->name;
        $attribute->save();
        DB::commit();
       
            return redirect()->route('admin.products.attribute')->with(['success' => 'تمت اضافة خاصيه جديده ']);
        }catch(\Exception $ex){
            DB::rollback();
            return redirect()->back()->with(['error' => 'هنالك خطا ']);
        }
        
    }

    public function editAttribute($id){
        $attribute = Attribute::find($id);
        return view('dashboard.products.attribute.edit', compact('attribute'));
    }
    
    public function updateAttribute(AttributeRequest $req,$id){
         try{
             
            DB::beginTransaction();
        $attribute = Attribute::find($id);
        $attribute ->name =$req->name;
        $attribute->save();
        DB::commit();
       
            return redirect()->route('admin.products.attribute')->with(['success' => 'تمت تعديل خاصيه جديده ']);
        }catch(\Exception $ex){
            DB::rollback();
            return redirect()->back()->with(['error' => 'هنالك خطا ']);
        }
    }
    
    public function deleteAttribute($id){
      
        try{
            DB::beginTransaction();
        $attribute = Attribute::find($id);
        $attribute->translations[0]->delete();
        $attribute->delete();
        DB::commit();
       
            return redirect()->route('admin.products.attribute')->with(['success' => 'تمت حذف خاصيه  ']);
        }catch(\Exception $ex){
            DB::rollback();
            return redirect()->back()->with(['error' => 'هنالك خطا ']);
        }
    }

    
    public function update(array $data, $id) {
        
    }

    public function delete($id) {
        
    }

    public function show($id) {
        
    }

}
