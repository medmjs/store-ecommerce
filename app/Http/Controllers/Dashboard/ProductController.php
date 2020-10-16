<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductPriceRequest;
use App\Http\Requests\ProductStockRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::select('id', 'slug', 'price', 'is_active', 'created_at')->paginate(PAGENATION_COUNT);
        return view('dashboard.products.general.index', compact('products'));


    }

    public function create()
    {
        $data = [];
        $data['brands'] = Brand::active()->select('id')->get();
        $data['tags'] = Tag::select('id')->get();
        $data['category'] = Category::active()->select('id')->get();

        return view('dashboard.products.general.create', compact('data'));

    }

    public function store(ProductRequest $req)
    {


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

    public function getPrice($id)
    {
        return view('dashboard.products.price.create',compact('id'));
    }
    public function storePrice(ProductPriceRequest $req)
    {
        try {

            Product::whereId($req->product_id)->update($req->only(['price','special_price','special_price_type','special_price_start','special_price_end']));



            return redirect()->route('admin.products')->with(['success' => 'تمت اضافة منتج جديد ']);

        }catch (\Exception $e){}

    }



    public function getStock($id)
    {
       // $product = Product::whereId($id)->select('sku','manage_stock','in_stock','qty')->get();
       $product = Product::find($id);

        return view('dashboard.products.Stock.create',compact('product'));
    }
    public function storeStock(ProductStockRequest $req)
    {
        try {


            //Product::whereId($req->product_id)->update($req->only(['sku','manage_stock','in_stock','qty']));
            Product::whereId($req->product_id)->update($req->except(['_token','product_id']));



            return redirect()->route('admin.products')->with(['success' => 'تمت اضافة منتج جديد ']);

        }catch (\Exception $e){}

    }



    public function update(array $data, $id)
    {

    }

    public function delete($id)
    {

    }

    public function show($id)
    {

    }
}
