<?php namespace Virgil\Store\Models;

use October\Rain\Database\Model;

/**
 * Review Model
 */
class Review extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'store_reviews';

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
    public $hasOne = [
        'user' => User::class
    ];
    public $belongsTo = [
        'product' => Product::class
    ];
}
