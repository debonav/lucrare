<?php namespace Virgil\Store\Models;

use October\Rain\Database\Model;

/**
 * Order Model
 */
class Order extends Model
{
    const STATUS_NEW = 0;
    const STATUS_PROCESSED = 1;
    const STATUS_DELIVERED = 2;
    /**
     * @var string The database table used by the model.
     */
    public $table = 'store_orders';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['id'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'user_id','price' , 'status'
    ];

    /**
     * @var array Relations
     */
    public $hasMany = [

    ];
    public $belongsTo = [
        'user' => User::class,
        'products' => [
            Product::class,
            'table' => 'store_order_products'
        ]
    ];

    public function getStatusOptions(){
        return [
            self::STATUS_NEW => "Comanda plasata",
            self::STATUS_PROCESSED => "Comanda procesata",
            self::STATUS_DELIVERED => "Comanda livrata",
        ];
    }
}
