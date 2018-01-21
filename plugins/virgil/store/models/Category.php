<?php namespace Virgil\Store\Models;

use October\Rain\Database\Model;

/**
 * Category Model
 */
class Category extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'store_categories';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasMany = [
        'products' => Product::class
    ];
}
