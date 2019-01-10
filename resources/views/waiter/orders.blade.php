
@extends('layouts.waiter')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Orders
        <small>My Orders</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Orders</li>
      </ol>
    </section>

    <!-- Main content -->
    <br />
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">My Orders</h3>
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
            <a class="btn btn-warning btn-sm" href="{{ URL::to('waiter/orders/report')}}">Report</a>
            <br><br>
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Order No.</th>
                  <th>Date</th>
                  <th>Amount</th>
                  <th>Status</th>
                  <th>Paid</th>
                  <th>Transacted By</th>
                  <th>Reversed By</th>
                  <th>Payment By</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; $total = 0;?>
                @foreach($orders as $order)
                <?php $total = $total + App\Orderitem::getAmount($order->id); ?>
                <tr>
                  <td>{{$i}}</td>
                  <td>{{$order->order_no}}</td>
                  <td>{{$order->created_at->format('Y-m-d')}}</td>
                  <td>{{number_format(App\Orderitem::getAmount($order->id),2)}}</td>
                  @if($order->is_cancelled == 1)
                  <td><span class="label label-danger">Reversed</span></td>
                  @else
                  <td><span class="label label-success">Complete</span></td>
                  @endif

                  @if($order->is_paid == 1)
                  <td><span class="label label-success">Paid</span></td>
                  @elseif($order->is_paid == 0 && $order->is_cancelled == 0)
                  <td><span class="label label-danger">Not Paid</span></td>
                  @else
                  <td><span class="label label-danger">Reversed</span></td>
                  @endif
                  

                  <td>{{App\User::getUser($order->waiter_id)}}</td>
                  @if($order->is_cancelled == 1)
                  <td>{{App\User::getUser($order->cancel_id)}}</td>
                  @else
                  <td></td>
                  @endif
                  
                  <td>{{App\User::getUser($order->payment_by) ? App\User::getUser($order->payment_by) : ""}}</td>
                  <td>
                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('waiter/order/show/'.$order->id)}}">View</a></li>
                    <li><a href="{{URL::to('receipt/'.$order->id)}}" target="_blank">Print Receipt</a></li>
                    <li><a href="{{URL::to('invoice/'.$order->id)}}" target="_blank">Invoice</a></li>
                    @if($order->is_paid == 0 && $order->is_cancelled == 0)
                    <li><a href="{{URL::to('/kitchen/order/cancel/'.$order->id)}}" onclick="return (confirm('Are you sure you want to reverse this order?'))">Reverse</a></li>
                    @endif
                    @if($order->is_cancelled == 1)
                    <li><a href="{{URL::to('/kitchen/order/return/'.$order->id)}}" onclick="return (confirm('Are you sure you want to return this order?'))">Return</a></li>
                    @endif
                    <li><a href="{{URL::to('waiter/orders/individual/report/'.$order->id)}}">Report</a></li>
                  </ul>
              </div>

                    </td>
                </tr>
                <?php $i++;?>
                @endforeach
                </tbody>

                <tfoot>
                   
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>{{number_format($total,2)}}</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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