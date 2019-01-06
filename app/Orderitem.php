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
                    ->join('orders','orderitems.order_id','=','orders.id')
                    ->selectRaw('SUM(orderitems.amount * quantity) as total')
                    ->where('order_id',$id)
                    ->where('orders.is_paid',1)
                    ->where('orderitems.is_cancelled',0)
                    ->first()->total;
        
        return $amount;
    }
}
