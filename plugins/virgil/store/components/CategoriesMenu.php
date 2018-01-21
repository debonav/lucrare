<?php namespace Virgil\Store\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\DB;
use Virgil\Store\Models\Category;
use Virgil\Store\Models\Product;

class CategoriesMenu extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'CategoriesMenu Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function getItems(){
        $categories = Category::select(['id','name'])->get()->toArray();
        $productCounts = Product::select(['category_id',DB::raw('count(id) as count')])->groupBy('category_id')->get();
        foreach ($categories as $key => $category){
            $categories[$key]['count'] = $productCounts->where('category_id',$category['id'])->first()->count;
        }
        return $categories;
    }

    public function renderMenu(){
        return 1223;
    }
}
