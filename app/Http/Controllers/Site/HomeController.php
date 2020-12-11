<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class HomeController extends Controller
{
      public function home()
    {
          $data = [];
        $data['sliders'] = Slider::select('id','photo')->get();
        return  view('front.home', compact('data'));
    }
}
