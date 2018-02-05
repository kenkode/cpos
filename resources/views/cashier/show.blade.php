
@extends('layouts.cashier')
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
        <li><a href="{{URL::to('/admin/orders')}}"><i class="fa fa-shopping-cart"></i>Orders</a></li>
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
            @if(App\Order::getOrder($id)->is_cancelled == 0 && App\Order::getOrder($id)->is_paid == 0)
            <a class="btn btn-success" href="{{URL::to('cashier/order/transact/'.App\Order::getOrder($id)->id)}}">Complete Transaction</a>
            @elseif(App\Order::getOrder($id)->is_paid == 1)
            <a class="btn btn-danger" href="{{URL::to('cashier/order/reverse/'.App\Order::getOrder($id)->id)}}" onclick="return (confirm('Are you sure you want to reverse this transaction?'))">Reverse Transaction</a>
            @endif
            <a target="_blank" class="btn btn-primary" href="{{URL::to('receipt/'.App\Order::getOrder($id)->id)}}">Print Receipt</a>
            <a class="btn btn-warning" href="{{URL::to('/admin/orders/individual/report/'.App\Order::getOrder($id)->id)}}">Report</a>
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
                  @if(App\Order::getOrder($id)->is_complete == 0 && App\Order::getOrder($id)->is_paid == 0)
                  <th>Action</th>
                  @endif
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
                  @if(App\Order::getOrder($id)->is_complete == 1)
                  <td><span class="label label-success">Complete</span></td>
                  @elseif($orderitem->is_cancelled == 1)
                  <td><span class="label label-danger">Cancelled</span></td>
                  @elseif($orderitem->is_cancelled == 0 && App\Order::getOrder($id)->is_complete == 0)
                  <td><span class="label label-warning">Pending</span></td>
                  @endif
                  @if(App\Order::getOrder($id)->is_complete == 0 && App\Order::getOrder($id)->is_paid == 0)
                  <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('orderitem/show/'.$orderitem->id)}}">View</a></li>
                    @if($orderitem->is_cancelled == 0)
                    <li><a href="{{URL::to('admin/orderitem/cancel/'.$orderitem->id)}}" onclick="return (confirm('Are you sure you want to cancel this order?'))">Cancel</a></li>
                    @endif
                    @if($orderitem->is_cancelled == 1)
                    <li><a href="{{URL::to('admin/orderitem/return/'.$orderitem->id)}}" onclick="return (confirm('Are you sure you want to return this order?'))">Return</a></li>
                    @endif
                  </ul>
              </div>

                    </td>
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
                    <td><strong>{{number_format($amount,2)}}</strong></td>
                    <td><strong>{{number_format($total,2)}}</strong></td>
                    <td></td>
                    @if(App\Order::getOrder($id)->is_complete == 0 && App\Order::getOrder($id)->is_paid == 0)
                    <td>Action</td>
                    @endif
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