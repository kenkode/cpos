<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Redirect;
use App\Orderitem;
use App\Order;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 'admin'){
            return view('admin.index');
        }else if(Auth::user()->role == 'waiter'){
            $orders = Order::whereDate('created_at',date('Y-m-d'))->orderBy('id','DESC')->where('waiter_id',Auth::user()->id)->get();
            $myorders = Order::where('waiter_id',Auth::user()->id)->count();
            $cancelledorders = Order::where('waiter_id',Auth::user()->id)->where('is_cancelled',1)->count();
            $total = Orderitem::where('waiter_id',Auth::user()->id)->where('is_cancelled',0)->sum('amount');
            return view('waiter.index',compact('orders','myorders','cancelledorders','total'));
        }
    }
}
