<?php

// jCart v1.3
// http://conceptlogic.com/jcart/

// This file demonstrates a basic checkout page

// If your page calls session_start() be sure to include jcart.php first
include_once('jcart/jcart.php');

error_reporting(1);

//use rpos\vendor\laravel\framework\src\Illuminate\Support\Facades\Auth;

    $con = mysqli_connect("localhost","root","","rpos");
	
	if (mysqli_connect_errno())
    {
     echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

session_start();

echo Auth::user()->id;

foreach($jcart->get_contents() as $item)	{
$sql = mysqli_query($con,"insert into orderitems(food_id,quantity,size,amount,is_complete,is_received,waiter_id,created_at)values('".preg_replace("/[^0-9]/",'',$item['id'])."', '".$item['qty']."', '".$item['size']."', '".$item['amount']."', 0, 0, , NOW())") or die(mysqli_error($con));
}
?>
