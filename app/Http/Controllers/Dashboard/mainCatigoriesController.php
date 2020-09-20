<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoriesRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;


class mainCatigoriesController extends Controller
{
    //
    public function index()
    {

        //$cat = Category::all();
        //$cat->makeVisible('translations');
        // $cat=Category::parent()->select('id','slug')->get();
        $category = Category::parent()->paginate(PAGENATION_COUNT);
        return view('dashboard.categories.index', compact('category'));

    }

    public function create()
    {
        $main = Category::parent()->get();

        return view('dashboard.categories.create',compact('main'));
    }

    public function store(MainCategoriesRequest $req)
    {
        //validation

        if (!$req->has('is_active'))
            $req->request->add(['is_active' => 0]);
        else
            $req->request->add(['is_active' => 1]);


        if(!$req->has('mainCat')||($req->mainCat ==0))
            $req->request->add(['parent_id'=>null]);
        else
            $req->request->add(['parent_id'=>$req->mainCat]);



        try {
            DB::beginTransaction();
            $cat = Category::create($req->all());
            $cat->name = $req->name;

            //$cat = Category::create($req->except('_token'));
            $cat->save();
            DB::commit();
            return redirect()->route('admin.mainCategories')->with(['success' => 'تمت اضافة قسم جديد ']);

        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'هنالك خطا ']);
        }

    }

    public function edit($id)
    {
        //check if category is exist
        $category = Category::find($id);
        if (!$category) {
            return redirect()->back()->with(['error' => 'هذا القسم غير موجود']);
        } else {
            return view('dashboard.categories.edit', compact('category'));
        }


    }

    public function update($id, MainCategoriesRequest $req)
    {

        try {
            if (!$req->has('is_active'))
                $req->request->add(['is_active' => 0]);
            else
                $req->request->add(['is_active' => 1]);

            $cat = Category::find($id);

            if (!$cat) {
                return redirect()->back()->with(['error' => 'هذا القسم غير موجود ']);
            } else {
                $cat->update(['slug' => $req->slug, 'is_active' => $req->is_active]);

                $cat->name = $req->name;

                $cat->save();

                return redirect()->route('admin.mainCategories')->with(['success' => 'تمت العمليه بالنجاح ']);

            }


        } catch (\Exception $ex) {


        }


    }

    public function delete($id)
    {
        try {
            $cat = Category::find($id);
            $action = $cat->delete();

            if ($action == 1)
                return redirect()->route('admin.mainCategories')->with(['success' => 'تمت العمليه بالنجاح ']);
            else
                return redirect()->route('admin.mainCategories')->with(['error' => 'هنالك خطاء']);


        } catch (\Exception $ex) {

        }


    }

    public function changeStatus()
    {

    }
}
