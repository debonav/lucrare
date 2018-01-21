<?php namespace Virgil\Store\Console;

use Illuminate\Console\Command;
use System\Models\File;
use Virgil\Store\Models\Product;
use Faker\Factory as Faker;


class SeedImagesToProducts extends Command
{
    private $faker;

    public function __construct()
    {
        parent::__construct();
        $this->faker = Faker::create();
    }

    /**
     * @var string The console command name.
     */
    protected $name = 'store:seedimagestoproducts';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $products = Product::all();

        $bar = $this->output->createProgressBar($products->count());
        foreach ($products as $product){
            for ($i = 1 ; $i <= random_int(1,5); $i++){
                $image = $this->faker->image("/tmp",800,600,'technics');
                $parts = explode("/",$image);
                $name = end($parts);
                $file = (new File())->fromData(file_get_contents($image), $name);
                $product->pictures()->add($file);
                unlink($image);
            }
            $bar->advance();
        }
        $bar->finish();
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
