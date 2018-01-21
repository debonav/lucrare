<?php namespace Virgil\Store\Components;

use Cms\Classes\ComponentBase;
use Virgil\Store\Models\Product;

class Products extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Products Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function getProducts($count = null){
        if ($count){
            return Product::take($count)->get();
        }
        return Product::paginate(12);
    }
}
