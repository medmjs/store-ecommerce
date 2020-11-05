<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;


class Option extends Model
{
    //
    use Translatable;

    protected $with=['translations'];

    protected $translatedAttributes =['name'];

    protected $fillable =['id','product_id','attribute_id'];

    protected $hidden =['translations'];//return translations when I  need it

    protected $casts=[
      'is_active'=>'boolean',
    ];

    
    public function scopeActive($query){
        return $query->where('is_active',1);
    }





    public function getActive(){
        return $this->is_active == 1 ? 'Active' : 'not Active';
    }
    
    
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    
     public function attripute() {
        return $this->belongsTo(Attribute::class,'attribute_id');
        
    }
   

   


}
