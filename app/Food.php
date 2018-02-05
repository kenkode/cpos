<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    //
    public function foodcategory(){

		return $this->belongsTo('App\Foodcategory');
	}

	public function orderitems(){

		return $this->hasMany('App\Orderitem');
	}

	public static function getFood($id){

		return Food::find($id);
	}
}
