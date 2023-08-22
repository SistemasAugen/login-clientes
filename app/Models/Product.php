<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    public function type()
    {
        return $this->hasOne('App\Type','id','type_id');
    }

    public function subcategories()
    {
        return $this->belongsToMany('App\Models\Subcategory','product_has_subcategories');
    }

    public function extras()
    {
        return $this->belongsToMany('App\Models\Extra','extra_has_products');
    }

    public function prices(){
        return $this->hasMany('App\Models\ProductHasSubcategory','product_id');
    }


}
