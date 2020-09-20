<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Requests\TagsRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagsController extends Controller
{
    public function index()
    {

        $tags = Tag::orderBy('id','DESC')->paginate(PAGENATION_COUNT);
        return view('dashboard.tags.index',compact('tags'));
    }
    public function create()
    {
        return view('dashboard.tags.create');
    }

    public function store(TagsRequest $req)
    {
        try {
            DB::beginTransaction();
            $tag = Tag::create(['slug'=>$req->slug]);
            $tag->name = $req->name;
            $tag->save();
            DB::commit();
            return redirect()->route('admin.tags')->with(['success'=>'تمت العنليه بنجاح']);

        }catch (\Exception $ex){

            DB::rollBack();
        }



    }

    public function edit($id)
    {
        $tag = Tag::find($id);
        return view('dashboard.tags.edit',compact('tag'));

    }

    public function update($id, TagsRequest $req)
    {
        try {


            $tag = Tag::find($id);
            $tag->update(['slug'=>$req->slug]);
            $tag->name = $req->name;
            $tag->save();

            return redirect()->route('admin.tags')->with(['success'=>'مت العمليه بالنجاح']);
        }catch (\Exception $ex){


        }



    }

    public function delete($id)
    {
        try {

            $tag = Tag::find($id);
            $action = $tag->delete();
            if($action == 1 )
                return redirect()->route('admin.tags')->with(['success'=>'تم حذف العنصر']);
            else
                return redirect()->route('admin.tags')->with(['error'=>'هنالك خطاء']);
        }catch (\Exception $ex){

        }

    }

    public function changeStatus()
    {

    }
}
