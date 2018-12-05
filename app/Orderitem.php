<?php

namespace App;
use DB;

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

        $amount = DB::table('orderitems')
                    ->selectRaw('SUM(amount * quantity) as total')
                    ->where('order_id',$id)
                    ->where('is_cancelled',0)
                    ->first()->total;
        
        return $amount;
    }
}
