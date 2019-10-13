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

    //country relation
    public function country(){
        return $this->belongsTo('App\Countries');
    }

    //category relation
    public function category(){
        return $this->hasOne('App\Categories', 'number', 'category_id');
    }
}
