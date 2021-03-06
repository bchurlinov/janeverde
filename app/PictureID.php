<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PictureID extends Model
{
    protected $table = "pictureid";
    public $timestamps = false;
    
    public function user(){
        return $this->belongsTo('App\User');
    }
}
