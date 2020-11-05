<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = 'category';
    protected $keyType = 'string';
    protected $primaryKey = 'slug';

    public function subCategory() {
        return $this->hasMany('App\SubCategory','id_category','slug')->get();
    }

    
}
