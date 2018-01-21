<?php namespace Virgil\Store\Models;

use October\Rain\Database\Model;

/**
 * User Model
 */
class User extends \RainLab\User\Models\User
{

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['id'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
//        'first_name',
        'name',
        'email',
        'password',
    ];

    /**
     * @var array Relations
     */
    public $hasMany = [
        'comments' => Comment::class,
        'reviews' => Review::class,
        'orders' => Order::class
    ];

}
