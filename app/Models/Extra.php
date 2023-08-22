<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    public function products()
    {
        return $this->belongsToMany('App\Models\Product','extra_has_products');
    }
}
