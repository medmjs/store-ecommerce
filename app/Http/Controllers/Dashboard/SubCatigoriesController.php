<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoriesRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubCatigoriesController extends Controller
{

    public function index()
    {


        $category = Category::subcategory()->paginate(PAGENATION_COUNT);


        return view('dashboard.subcategories.index', compact('category'));

    }

    public function create()
    {
        $category = Category::parent()->get();


        return view('dashboard.subcategories.create', compact('category'));
    }

    public function store(MainCategoriesRequest $req)
    {

        if (!$req->has('is_active'))
            $req->request->add(['is_active' => 0]);
        else
            $req->request->add(['is_active' => 1]);


        try {
            Db::beginTransaction();
            $cat = Category::create($req->except('_token'));
            $cat->name = $req->name;
            $cat->save();
            DB::commit();

            return redirect()->route('admin.subCatigories')->with(['success' => 'done']);


        } catch (\Exception $ex) {
            DB::rollBack();

        }
    }

    public function edit($id)
    {
        //check if category is exist
        $category = Category::find($id);
        if (!$category) {
            return redirect()->back()->with(['error' => 'هذا القسم غير موجود']);
        } else {
            $main = Category::parent()->get();
            return view('dashboard.subcategories.edit', compact('category','main'));

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
                $cat->update(['slug' => $req->slug,'parent_id'=>$req->parent_id,'is_active' => $req->is_active]);

                $cat->name = $req->name;

                $cat->save();

                return redirect()->route('admin.subCatigories')->with(['success' => 'تمت العمليه بالنجاح ']);

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
                return redirect()->route('admin.subCatigories')->with(['success' => 'تمت العمليه بالنجاح ']);
            else
                return redirect()->route('admin.subCatigories')->with(['error' => 'هنالك خطاء']);


        } catch (\Exception $ex) {

        }


    }

    public function changeStatus()
    {

    }

    private function getMainCategory($parent_id)
    {
        $cat = Category::find($parent_id);
        return $cat;
    }
}
