<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public function state()
    {
        return $this->hasOne('App\Models\State',"id","state_id");
    }

    public function town()
    {
        return $this->hasOne('App\Models\Town','id','town_id');
    }

    public function laboratory()
    {
        return $this->hasOne('App\Models\Laboratory','id','laboratory_id');
    }

    public function clients()
    {
        return $this->hasMany('App\Models\Client','branch_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order','branch_id');
    }
}
