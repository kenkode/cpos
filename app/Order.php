<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //

    public static function getOrder($id){

		return Order::find($id);
	}
}
