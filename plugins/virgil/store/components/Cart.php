<?php namespace Virgil\Store\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use \Illuminate\Support\Facades\Session;
use October\Rain\Support\Facades\Flash;
use Virgil\Store\Models\Order;
use Virgil\Store\Models\Product;
use Virgil\Store\Models\User;

class Cart extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Cart Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public static function getCartItems(){
        $cart = Session::get('cart', []);
        $cart['products'] = isset($cart['products'])?$cart['products'] : [];
        return $cart;

    }

    public static function getCartItemsCount(){
        $cart = Session::get('cart', []);
        return (isset($cart['products'])) ? count($cart['products']) : 0;
    }

    public function onAddToCart(){

        $data = post();
        $cart = Session::get('cart', []);
        $item = Product::find($data['id']);
        $total = 0;

        if (!isset($cart['products'])) {

            $cart['products'][] = [
                'id'    => $item->id,
                'name'  => $item->name,
                'price'  => $item->price,
                'count' =>  1,
            ];
            $total = $item->price;
        } else {
            $added = false;

            foreach ($cart['products'] as  $key => $product){
                if ($product['id'] == $item->id){
                    $cart['products'][$key]['count']++;
                    $added = true;
                }
                $total += $cart['products'][$key]['count'] * $cart['products'][$key]['price'];

            }
            if (!$added){
                $cart['products'][] = [
                    'id'    => $item->id,
                    'name'  => $item->name,
                    'price'  => $item->price,
                    'count' =>  1
                ];
                $total += $item->price;
            }
        }

        $cart['total'] = $total;


        Session::put('cart', $cart);

        return [
            'count' =>  count($cart['products']),
            'total' =>  $total
        ];


    }

    public function onRemoveFromCart(){

        $data = post();
        $cart = Session::get('cart', []);
        $total = $cart['total'];


        $item = Product::find($data['id']);

        if (!isset($cart['products'])) {

            $cart['products'] = [];
        } else {
            $count = 0;

            foreach ($cart['products'] as  $key => $product){
                if ($product['id'] == $item->id){
                    if ($cart['products'][$key]['count'] > 1) {
                        $cart['products'][$key]['count']--;
                        $count = $cart['products'][$key]['count'];
                        $total -= $item->price;
                    }
                    else {
                        unset($cart['products'][$key]);
                        $count = 0;
                        $total = 0;
                    }
                }

            }
        }


        $cart['total'] = $total;
        Session::put('cart', $cart);

        if ($total == 0){
            return Redirect::to("/");
        }

        return [
            'count' =>  count($cart['products']),
            'item_count'   => $count,
            'total'         => $total
        ];


    }

    public static function getOrders($id){

        return Order::where('user_id',$id)->get();
    }

    public function onBuy(){
        $data = post();

        $cart = Session::get('cart', []);

        $order = Order::create([
            'user_id' => $data['id'],
            'price'     =>  $cart['total'],
            'status'    => Order::STATUS_NEW
        ]);
        foreach ($cart['products'] as $product){
            for ($i = 1; $i <= $product['count'] ; $i++)
            DB::table('store_order_products')->insert([
                'order_id' => $order->id,
                'product_id' => $product['id'],
            ]);
        }

        Session::put('cart',[
            'products' => [],
            'total'     =>  0
        ]);

        return Redirect::to('/comenzi');
    }
}
