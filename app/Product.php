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

    public function buyerPurchasedProducts(){

    }
}
