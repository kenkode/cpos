<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getUser($id){
        if($id > 0 ){
        $user = User::find($id);
        return $user->name;
        }else{
            return '';
        }
    }

    public static function getOrders($id){
        $orders = Order::where('waiter_id',$id)->count();
        return $orders;
    }

    public static function getPending($id){
        $pending = Order::where('waiter_id',$id)->where('is_complete',0)->count();
        return $pending;
    }

    public static function getCancelled($id){
        $cancelled = Order::where('waiter_id',$id)->where('is_cancelled',1)->count();
        return $cancelled;
    }

    public static function getCompleted($id){
        $completed = Order::where('waiter_id',$id)->where('is_complete',1)->count();
        return $completed;
    }

    public static function getPaid($id){
        $paid = Order::where('waiter_id',$id)->where('is_paid',1)->count();
        return $paid;
    }

    public static function getUnpaid($id){
        $unpaid = Order::where('waiter_id',$id)->where('is_paid',0)->count();
        return $unpaid;
    }

    public static function getAmount($id){
        $amount = Orderitem::where('waiter_id',$id)->where('is_cancelled',0)->sum('amount');
        return $amount;
    }

    public static function getRangeOrders($id,$from,$to){
        $orders = Order::where('waiter_id',$id)->whereBetween('created_at', array($from, $to))->count();
        return $orders;
    }

    public static function getRangePending($id,$from,$to){
        $pending = Order::where('waiter_id',$id)->whereBetween('created_at', array($from, $to))->where('is_complete',0)->count();
        return $pending;
    }

    public static function getRangeCancelled($id,$from,$to){
        $cancelled = Order::where('waiter_id',$id)->whereBetween('created_at', array($from, $to))->where('is_cancelled',1)->count();
        return $cancelled;
    }

    public static function getRangeCompleted($id,$from,$to){
        $completed = Order::where('waiter_id',$id)->whereBetween('created_at', array($from, $to))->where('is_complete',1)->count();
        return $completed;
    }

    public static function getRangePaid($id,$from,$to){
        $paid = Order::where('waiter_id',$id)->whereBetween('created_at', array($from, $to))->where('is_paid',1)->count();
        return $paid;
    }

    public static function getRangeUnpaid($id,$from,$to){
        $unpaid = Order::where('waiter_id',$id)->whereBetween('created_at', array($from, $to))->where('is_paid',0)->count();
        return $unpaid;
    }

    public static function getRangeAmount($id,$from,$to){
        $amount = Orderitem::where('waiter_id',$id)->whereBetween('created_at', array($from, $to))->where('is_cancelled',0)->sum('amount');
        return $amount;
    }
}
