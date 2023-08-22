<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    public function subcategories()
    {
        return $this->belongsToMany('App\Models\Subcategory','categories_has_subcategories');
    }

    public function types()
    {
        return $this->belongsToMany('App\Models\Type','types_has_categories');
    }
}
