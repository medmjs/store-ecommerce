<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    
     protected $fillable = ['photo','is_active'];

    
     public function scopeActive($query){
        return $query->where('is_active',1);
    }

    public function getActive()
    {
        return $this->is_active == 1 ? 'Active' : 'not Active';
    }

    public function getPhotoAttribute($val){
        return ($val !== null) ? asset('assets/images/sliders/'.$val) : "";
        }
    
    
    
}
