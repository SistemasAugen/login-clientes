<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category','categories_has_subcategories');
    }
    public function types()
    {
        return $this->belongsToMany('App\Models\Type','subcategories_has_types');
    }
}
