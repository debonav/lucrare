<?php namespace Virgil\Store\Updates;

use October\Rain\Support\Facades\Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateManyToManyTables extends Migration
{
    public function up()
    {
        Schema::create('store_order_products', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('product_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('store_order_products');
    }
}
