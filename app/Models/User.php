<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'clients';
  
    protected $hidden = [
        'password',
    ];

    public function state()
    {
        return $this->hasOne('App\Models\State','id','state_id');
    }

    public function town()
    {
        return $this->hasOne('App\Models\Town','id','town_id');
    }

    public function discounts()
    {
        return $this->hasMany('App\Models\Discount','client_id');
    }
    public function facturacion()
    {
        return $this->hasOne('App\Models\Facturacion','client_id');
    }

    public function branch()
    {
        return $this->hasOne('App\Models\Branch','id','branch_id');
    }

    public function orders() {
        return $this->hasMany('App\Models\Order','client_id');
    }
}


