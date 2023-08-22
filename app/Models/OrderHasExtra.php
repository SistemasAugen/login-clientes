<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHasExtra extends Model
{
    public function extra()
    {
        return $this->hasOne('App\Models\Product','id','extra_id');
    }
}
