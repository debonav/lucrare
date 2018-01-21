<?php namespace Virgil\Store\Updates;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use October\Rain\Database\Updates\Seeder;
use System\Models\File;
use Virgil\Store\Models\Category;
use Virgil\Store\Models\Order;
use Virgil\Store\Models\Product;
use Virgil\Store\Models\User;
use Faker\Factory as Faker;

class SeedUsersTable extends Seeder
{
    private $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    public function run()
    {

        $this->seedUsers(100);
        $this->seedCategories(10);
        $this->seedProducts(100);
        $this->seedReviews();
        $this->seedReviews();
        for ($i = 1; $i <= 8; $i++){
            $this->seedOrders();
        }

    }

    private function seedUsers($count){
        $now = Carbon::now();
        User::truncate();

        echo 'Seed users '. PHP_EOL;
        for ($i = 1; $i<=$count; $i++){
            $password = bcrypt('password123');
            $email = $this->faker->email;
            DB::table('users')->insert([
                'name'    => $this->faker->name,
                'email'         => $email,
                'username'      => $email,
                'password'      => $password,
                'is_activated'  => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }
    }

    private function seedCategories($count){
        $now = Carbon::now();
        $list = [
            "Laptop, Tablete & Telefoane",
            "PC, Periferice & Software",
            "TV, Audio-Video & Foto",
            "Electrocasnice & Climatizare",
            "Gaming",
            "Fashion",
            "Ingrijire personala & Cosmetice",
            "Carti, Birotica & Cadouri",
            "Casa, Bricolaj & Petshop",
            "Sport & Activitati in aer liber",
            "Auto, Moto & RCA",
            "Jucarii, Copii & Bebe",
            "Supermarket",
        ];
        echo 'Seed Categories '. PHP_EOL;
        foreach ($list as $category){
            DB::table('store_categories')->insert([
                'name'          => $category,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }
    }

    private function seedProducts($count){
        $now = Carbon::now();
        echo 'Seed Products '. PHP_EOL;
        foreach (Category::all() as $category){

            for ($i = 1; $i<=random_int($count/2,$count); $i++){
                DB::table('store_products')->insert([
                    'name'          => $this->faker->unique()->sentence,
                    'price'         => $this->faker->randomFloat(2,1,100),
                    'description'   => $this->faker->sentence(random_int(8,22)),
                    'category_id'   => $category->id,
                    'available'     => random_int(0,20),
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ]);
            }


        }
    }

    private function seedReviews(){
        echo 'Seed Reviews '. PHP_EOL;
        $now = Carbon::now();
        $product_ids = array_column(
            Product::select('id')
                ->orderBy(DB::raw('RAND()'))
                ->take(Product::count() / 2)
                ->get()
                ->toArray(),

        'id'
        );
        foreach ($product_ids as $product_id){
            $user_ids = $product_ids = array_column(
                User::select('id')
                    ->orderBy(DB::raw('RAND()'))
                    ->take(random_int(1,User::count() / 4))
                    ->get()
                    ->toArray(),

                'id'
            );
            foreach ($user_ids as $user_id){
                DB::table('store_reviews')->insert([
                    'user_id'       => $user_id,
                    'product_id'    => $product_id,
                    'stars'         => random_int(1,5),
                ]);
                if (random_int(0,1)){
                    DB::table('store_comments')->insert([
                        'user_id'       => $user_id,
                        'product_id'    => $product_id,
                        'text'          => $this->faker->realText($this->faker->numberBetween(10,20)),
                        'created_at'    => $now,
                        'updated_at'    => $now,
                    ]);
                }
            }
        }
    }

    private function seedOrders(){
        $now = Carbon::now();
        $user_ids = $product_ids = array_column(
            User::select('id')
                ->orderBy(DB::raw('RAND()'))
                ->get()
                ->toArray(),

            'id'
        );

        foreach ($user_ids as $user_id){
            $products =
                Product::orderBy(DB::raw('RAND()'))
                    ->take(random_int(1,5))
                    ->get();
            $price = 0;
            $order = Order::create([
                'user_id' => $user_id,
                'price'     => 0,
                'status'    => 0
            ]);
            foreach ($products as $product){
                DB::table('store_order_products')->insert([
                    'order_id' => $order->id,
                    'product_id'    =>  $product->id
                ]);
                $price += $product->price;
            }
            $date = Carbon::now()
                ->subHours($user_id * 2)
                ->subDays(random_int(1,120));
            DB::table('store_orders')
                ->where('id',$order->id)
                ->update([
                    'price' =>  $price,
                    'created_at' => $date,
                    'updated_at' => $date,
                    'status'      => random_int(0,2)
                ]);
        }
    }
}