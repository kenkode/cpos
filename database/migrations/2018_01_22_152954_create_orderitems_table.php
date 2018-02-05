<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderitems', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('food_id');
            $table->integer('quantity');
            $table->string('size');
            $table->float('amount',15,2);
            $table->integer('is_complete');
            $table->integer('is_received');
            $table->datetime('received_time');
            $table->datetime('delivered_time');
            $table->integer('waiter_id');
            $table->integer('kitchen_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orderitems');
    }
}
