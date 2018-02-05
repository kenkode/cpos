<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Foodcategory extends Model
{
    //
    public function food(){

		return $this->hasMany('App\Food');
	}

	public static function getName($id){
        $food = Food::find($id);
		return Foodcategory::find($food->foodcategory_id)->name;
	}
}
