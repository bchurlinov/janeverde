<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use FullTextSearch;

    protected $table = 'products';

    protected $searchable = [
        'title',
        'description',
        'location'
    ];

    //user relation
    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function userAlter(){
        return $this->hasOneThrough('App\BusinessLicense', 'App\User', 'id', 'user_id', 'user_id', 'id');
    }

    //country relation
    public function country(){
        return $this->belongsTo('App\Countries');
    }

    //category relation
    public function category(){
        return $this->hasOne('App\Categories', 'number', 'category_id');
    }

    //subcategory relation
    public function subcategory(){
        return $this->hasOne('App\Subcategories', 'number', 'subcategory_id');
    }
}
