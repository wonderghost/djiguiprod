<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    //
    protected $table = 'sub_category';
    protected $keyType = 'string';
    protected $primaryKey = 'slug';

    public function category() {
        return $this->belongsTo('App\Category','id_category','slug')->first();
    }

    public function articles() {
        return $this->hasMany('App\Article','id_sub_category','slug')->get();
    }
}
