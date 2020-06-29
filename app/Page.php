<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //
    protected $table = 'pages';
    protected $keyType = 'string';
    protected $primaryKey = 'slug';
    
}
