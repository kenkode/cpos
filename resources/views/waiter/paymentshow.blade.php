
@extends('layouts.waiter')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{URL::to('/waiter/orders')}}"><i class="fa fa-shopping-cart"></i>Orders</a></li>
        <li class="active">Show</li>
      </ol>
    </section>

    <!-- Main content -->
    <br />
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Ordered Meals</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            
          @if (Session::has('flash_message'))

            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            {{ Session::get('flash_message') }}
           </div>
          @endif

           @if (Session::has('delete_message'))

            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            {{ Session::get('delete_message') }}
           </div>
          @endif
            <!-- /.box-header -->
            <!-- form start -->
            <h4 style="color: green"><strong>Order Number: {{App\Order::getOrder($id)->order_no}}<br> 
            @if(App\Order::getOrder($id)->is_cancelled == 1)
                  <td><span style="color: red">Status: Reversed</span></td>
                  @else
                  <td><span style="color: green">Status: Paid</span></td>
                  @endif<br>
            Payment by: {{App\User::getUser(App\Order::getOrder($id)->payment_by) ? App\User::getUser(App\Order::getOrder($id)->payment_by) : ""}}</strong></h4>
            @if(App\Order::getOrder($id)->is_cancelled == 1)
            <a class="btn btn-warning" href="{{URL::to('kitchen/order/return/'.App\Order::getOrder($id)->id)}}" onclick="return (confirm('Are you sure you want to return Payment By: this order?'))">Return Order</a>
            @endif

            @if(App\Order::getOrder($id)->is_paid == 0 && App\Order::getOrder($id)->is_cancelled == 0)
            <a class="btn btn-success" href="{{URL::to('waiter/complete/order/'.App\Order::getOrder($id)->id)}}">Complete Order</a>
            @endif
            
            @if(App\Order::getOrder($id)->is_cancelled == 0 && App\Order::getOrder($id)->is_paid == 0)
            <a class="btn btn-danger" href="{{URL::to('kitchen/order/cancel/'.App\Order::getOrder($id)->id)}}" onclick="return (confirm('Are you sure you want to reverse this order?'))">Reverse Order</a>
            @endif
            
            <a target="_blank" class="btn btn-primary" href="{{URL::to('receipt/'.App\Order::getOrder($id)->id)}}">Print Receipt</a>
            <a class="btn btn-warning" href="{{URL::to('/waiter/orders/individual/report/'.App\Order::getOrder($id)->id)}}">Report</a>
            <br><br>
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Category</th>
                  <th>Size</th>
                  <th>Date</th>
                  <th>Quantity</th>
                  <th>Amount</th>
                  <th>Total</th>
                  <th>Status</th>
                  
                </tr>
                </thead>
                <tbody>
                <?php $i=1; $quantity=0; $amount=0; $total=0;?>
                @foreach($orderitems as $orderitem)
                @if($orderitem->is_cancelled == 0)
                <?php
                 $quantity = $quantity + $orderitem->quantity;
                 $amount   = $amount   + $orderitem->amount;
                 $total    = $total    + ($orderitem->quantity * $orderitem->amount);
                ?>
                @endif
                <tr>
                  <td>{{$i}}</td>
                  <td><img src="{{asset('images/'.App\Food::getFood($orderitem->food_id)->image)}}" width="50" height="50" /></td>
                  <td>{{App\Food::getFood($orderitem->food_id)->name}}</td>
                  <td>{{App\Foodcategory::getName($orderitem->food_id)}}</td>
                  <td>{{$orderitem->size}}</td>
                  <td>{{$orderitem->created_at->format('Y-m-d')}}</td>
                  <td>{{$orderitem->quantity}}</td>
                  <td>{{number_format($orderitem->amount,2)}}</td>
                  <td>{{number_format($orderitem->amount * $orderitem->quantity,2)}}</td>
                  @if(App\Order::getOrder($id)->is_cancelled == 1)
                  <td><span class="label label-danger">Reversed</span></td>
                  @else
                  <td><span class="label label-success">Complete</span></td>
                  @endif
                  
                </tr>
                <?php $i++;?>
                @endforeach
                </tbody>

                <tfoot>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>{{$quantity}}</strong></td>
                    <!-- <td><strong>{{number_format($amount,2)}}</strong></td> -->
                    <td colspan="2" align="right"><strong>KES {{number_format($total,2)}}</strong></td>
                    <td></td>
                    
                </tfoot>
               
              </table>
            
          <!-- /.box -->
        </div>
        
          </div>
          </div>

          </div>
          <!-- /.box -->

        </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @stop