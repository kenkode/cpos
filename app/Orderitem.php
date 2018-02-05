<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderitem extends Model
{
    //
    public function food(){

		return $this->belongsTo('App\Food');
	}

	public static function getQuantity($id){
        $orderitems = Orderitem::where('order_id',$id)->get();
        $quantity = 0;
        foreach ($orderitems as $orderitem) {
        	$quantity = $quantity + $orderitem->quantity;
        }
		return $quantity;
	}

    public static function getAmount($id){
        $amount = Orderitem::where('order_id',$id)->where('is_cancelled',0)->sum('amount');
        
        return $amount;
    }
}
