<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CultivationLicense extends Model
{
    protected $table = "cultivationlicense";
    public $timestamps = false;

    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function country(){
        return $this->hasOne('App\Countries', 'id', 'country_id');
    }
}
