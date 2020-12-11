<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;

class DropzoneController extends Controller
{
    function index($id)
    {
      
        $images = Image::where('product_id',$id)->select('id','product_id','photo')->get();
        
        
     return view('dashboard.products.image.create', compact('images'))->withId($id);
    }

    function upload(Request $request)
    {
     
        
     
     $image = $request->file('file');

     $imageName = time() . '.' . $image->extension();

     $image->move(public_path('assets/images/products'), $imageName);

     
     
         Image::create([
                        'product_id' => $request->product_id,
                        'photo' => $imageName,
                    ]);
     
     
                    return redirect()->back();
     
    // return response()->json(['success' => $imageName]);
    }

    function fetch()
    {
        
     $images = \File::allFiles(public_path('assets/images/products'));
     $output = '<div class="row">';
     foreach($images as $image)
     {
      $output .= '
      <div class="col-md-2" style="margin-bottom:16px;" align="center">
                <img src="'.asset('assets/images/products/' . $image->getFilename()).'" class="img-thumbnail" width="175" height="175" style="height:175px;" />
                <button type="button" class="btn btn-link remove_image" id="'.$image->getFilename().'">Remove</button>
            </div>
      ';
     }
     $output .= '</div>';
     echo $output;
     
    }

    function delete($id)
    {
        
         $image = Image::find($id);
         $image->delete();
         
         return redirect()->back();
        
    /* if($image->get('name'))
     {
      \File::delete(public_path('images/' . $request->get('name')));
     }*/
    }
}

