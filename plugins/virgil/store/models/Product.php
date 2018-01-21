<?php namespace Virgil\Store\Models;

use Illuminate\Support\Facades\DB;
use October\Rain\Database\Model;
use System\Models\File;

/**
 * Product Model
 */
class Product extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'store_products';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['id'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name','price'];

    protected $appends = ['rating'];

    /**
     * @var array Relations
     */
    public $hasMany = [
        'reviews' => Review::class,
        'comments' => Comment::class,
        'orders' => [
            Order::class,
            'table' => 'store_order_products'
        ]

    ];
    public $belongsTo = [
        'category' => Category::class
    ];
    public $attachMany = [
        'pictures' => File::class
    ];

    public function getSlugAttribute(){
        return str_slug($this->name);
    }
    public function getRatingAttribute(){
        if (!$this->id)
            return null;

        $sum = DB::table('store_reviews')->where('product_id',$this->id)->select(DB::raw('SUM(stars) as stars'))->first();
        $count = DB::table('store_reviews')->where('product_id',$this->id)->count();

        if ($count)
            $rating = round($sum->stars / $count);
        else $rating = 0;
        return $rating;
    }
    public function getReverseRatingAttribute(){
        return 5 - $this->rating;
    }

    public function getImageAttribute(){
        if ($this->pictures()->count() > 0){
            return $this->pictures()->first()->getPath();
        }
    }

    public function getCategoryIdOptions(){
        $options = [];
        foreach (Category::all() as $category){
            $options[$category->id] = $category->name;
        }

        return $options;
    }
}
