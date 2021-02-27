<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class advertisement extends Model
{
    protected $fillable = [
        'slug', 'description', 'image', 'nameClient', 'contactClient', 'zone', 'state'
    ];

    protected $keyType = "string";
    protected $primaryKey = "slug";
}
