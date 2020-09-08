<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;


class Category extends Model
{
    //
    use Translatable;

    protected $with=['translations'];

    protected $translatedAttributes =['name'];

    protected $fillable =['parent_id','slug','is_active'];

    protected $hidden =['translations'];//return translations when I  need it

    protected $casts=[
      'is_active'=>'boolean',
    ];


}
