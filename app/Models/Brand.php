<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //
    use Translatable;

    protected $with = ['translations'];
    protected $translatedAttributes = ['name'];

    protected $fillable = ['is_active','photo'];

    //protected $hidden =['translations'];//return translations when I  need it

    protected $casts = [
        'is_active' => 'boolean',
    ];


    public function getActive()
    {
        return $this->is_active == 1 ? 'Active' : 'not Active';
    }


}
