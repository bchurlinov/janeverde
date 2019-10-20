<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndustrialLicense extends Model
{
    protected $table = "industriallicense";
    public $timestamps = false;

    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function country(){
        return $this->hasOne('App\Countries', 'id', 'country_id');
    }
}
