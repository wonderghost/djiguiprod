<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    protected $table = 'article';
    protected $keyType = 'string';
    protected $primaryKey = 'slug';

    public function subCategory() {
        return $this->belongsTo('App\SubCategory','id_sub_category','slug');
    }
    
    public function author() {
        return $this->belongsTo('App\User','author','email')->first();
    }
}
