<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caroussel extends Model
{

    protected $fillable = [
        'slug', 'name', 'image',
    ];

    protected $keyType = "string";
    protected $primaryKey = "slug"; 
}
