<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
 
    function index()
    {
    
         
          $images = Slider::select('id','photo')->get();
        
        
     return view('dashboard.sliders.index', compact('images'));
   
        
    }
    
    function create()
    {
        
    $images = Slider::select('id','photo')->get();
        
        
     return view('dashboard.sliders.create', compact('images'));
     
    }
    
  
    
    
     function upload(Request $request)
    {
     
        
     
     $image = $request->file('file');

     $imageName = time() . '.' . $image->extension();

     $image->move(public_path('assets/images/Sliders'), $imageName);

     
     
     Slider::create([                        
                        'photo' => $imageName,
                    ]);
     
     
                    return redirect()->back();
     
    // return response()->json(['success' => $imageName]);
    }
    
       function fetch()
    {
        
     $images = \File::allFiles(public_path('assets/images/sliders'));
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
        
         $image = Slider::find($id);
         $image->delete();
         
         return redirect()->back();
        
    /* if($image->get('name'))
     {
      \File::delete(public_path('images/' . $request->get('name')));
     }*/
    }
    
    
}
