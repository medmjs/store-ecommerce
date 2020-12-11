<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;


class User_Verfication extends Model
{
    

    protected $fillable =['user_id','code'];

   
    public $table="user_verfication";









    public function User(){
        return $this->belongsTo(Product::class,'user_id');
    }
    

   


}
