
@extends('layouts.kitchen')
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
        <li><a href="{{URL::to('/')}}"><i class="fa fa-shopping-cart"></i>Orders</a></li>
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
            <br><br>
            <h4 style="color: green"><strong>Order Number: {{App\Order::getOrder($id)->order_no}}</strong></h4>
            @if(App\Order::getOrder($id)->is_cancelled == 1)
            <a class="btn btn-warning" href="{{URL::to('kitchen/order/return/'.App\Order::getOrder($id)->id)}}" onclick="return (confirm('Are you sure you want to cancel this order?'))">Return Order</a>
            @endif
            @if(App\Order::getOrder($id)->is_cancelled == 0)
            @if(App\Order::getOrder($id)->is_complete == 0)
            <a class="btn btn-success" href="{{URL::to('kitchen/order/complete/'.App\Order::getOrder($id)->id)}}">Complete Order</a>
            @endif
            @endif
            @if(App\Order::getOrder($id)->is_complete == 1)
            <a class="btn btn-danger" href="{{URL::to('kitchen/order/uncomplete/'.App\Order::getOrder($id)->id)}}">Reverse Order</a>
            @endif
            @if(App\Order::getOrder($id)->is_complete == 0)
            @if(App\Order::getOrder($id)->is_cancelled == 0)
            <a class="btn btn-danger" href="{{URL::to('kitchen/order/cancel/'.App\Order::getOrder($id)->id)}}" onclick="return (confirm('Are you sure you want to cancel this order?'))">Cancel Order</a>
            @endif
            @endif
            <a class="btn btn-warning" href="{{URL::to('/kitchen/orders/individual/report/'.App\Order::getOrder($id)->id)}}">Report</a>
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
                  <th>Status</th>
                  @if(App\Order::getOrder($id)->is_complete == 0)
                  <th>Action</th>
                  @endif
                </tr>
                </thead>
                <tbody>
                <?php $i=1; $quantity=0; $amount=0; $total=0;?>
                @foreach($orderitems as $orderitem)
                <?php
                 $quantity = $quantity + $orderitem->quantity;
                 $amount   = $amount   + $orderitem->amount;
                 $total    = $total    + ($orderitem->quantity * $orderitem->amount);
                ?>
                <tr>
                  <td>{{$i}}</td>
                  <td><img src="{{asset('images/'.App\Food::getFood($orderitem->food_id)->image)}}" width="50" height="50" /></td>
                  <td>{{App\Food::getFood($orderitem->food_id)->name}}</td>
                  <td>{{App\Foodcategory::getName($orderitem->food_id)}}</td>
                  <td>{{$orderitem->size}}</td>
                  <td>{{$orderitem->created_at->format('Y-m-d')}}</td>
                  <td>{{$orderitem->quantity}}</td>
                  @if(App\Order::getOrder($id)->is_complete == 1)
                  <td><span class="label label-success">Complete</span></td>
                  @elseif(App\Order::getOrder($id)->is_cancelled == 1)
                  <td><span class="label label-danger">Cancelled</span></td>
                  @elseif($orderitem->is_cancelled == 0 && App\Order::getOrder($id)->is_complete == 0)
                  <td><span class="label label-warning">Pending</span></td>
                  @endif
                  @if(App\Order::getOrder($id)->is_complete == 0)
                  <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    @if($orderitem->is_cancelled == 0)
                    <li><a href="{{URL::to('kitchen/orderitem/cancel/'.$orderitem->id)}}" onclick="return (confirm('Are you sure you want to cancel this order?'))">Cancel</a></li>
                    @endif

                    @if($orderitem->is_cancelled == 1)
                    <li><a href="{{URL::to('kitchen/orderitem/return/'.$orderitem->id)}}" onclick="return (confirm('Are you sure you want to cancel this order?'))">Return</a></li>
                    @endif
                  </ul>
              </div>

                    </td>
                    @endif
                </tr>
                <?php $i++;?>
                @endforeach
                </tbody>
               
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