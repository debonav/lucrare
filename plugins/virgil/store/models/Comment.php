<?php namespace Virgil\Store\Models;

use October\Rain\Database\Model;

/**
 * Comment Model
 */
class Comment extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'store_comments';

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

    ];
    public $belongsTo = [
        'product' => Product::class,
        'user' => User::class
    ];
}
