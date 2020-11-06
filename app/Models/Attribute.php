<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    //
    use Translatable;

    protected $with = ['translations'];
    protected $translatedAttributes = ['name'];

    protected $guarded = [];

    //protected $hidden =['translations'];//return translations when I  need it

    public function options() {
        return $this->hasMany(Option::class,'attribute_id');
        
    }
   

}
