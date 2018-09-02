<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model {

    static function getProducts() {
        return $products = Products::get();
    }

}
