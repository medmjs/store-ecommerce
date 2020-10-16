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

    protected $fillable =['id','parent_id','slug','is_active'];

    protected $hidden =['translations'];//return translations when I  need it

    protected $casts=[
      'is_active'=>'boolean',
    ];

    public function scopeParent($query){
        return $query->whereNull('parent_id');
    }
    public function scopeSubcategory($query){
        return $query->whereNotNull('parent_id');
    }

    public function scopeActive($query){
        return $query->where('is_active',1);
    }





    public function getActive(){
        return $this->is_active == 1 ? 'Active' : 'not Active';
    }

    public function _parent(){
        return $this->belongsTo(self::class ,'parent_id');
    }


}
