
@extends('layouts.kitchen')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Orders
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Completed Orders</li>
      </ol>
    </section>

    <!-- Main content -->
     <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Completed Orders</h3>
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
            <a class="btn btn-warning btn-sm" href="{{ URL::to('kitchen/orders/report')}}">Report</a>
            <br><br>
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Order No.</th>
                  <th>Date</th>
                  <th>Quantity</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1;?>
                @foreach($completeorders as $order)
                <tr>
                  <td>{{$i}}</td>
                  <td>{{$order->order_no}}</td>
                  <td>{{$order->created_at->format('Y-m-d')}}</td>
                  <td>{{App\Orderitem::getQuantity($order->id)}}</td>
                  @if($order->is_complete == 1)
                  <td><span class="label label-success">Complete</span></td>
                  @elseif($order->is_cancelled == 1)
                  <td><span class="label label-danger">Cancelled</span></td>
                  @elseif($order->is_cancelled == 0 && $order->is_complete == 0)
                  <td><span class="label label-warning">Pending</span></td>
                  @endif
                  <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('kitchen/order/show/'.$order->id)}}">View</a></li>
                    <li><a href="{{URL::to('kitchen/order/uncomplete/'.$order->id)}}">Reverse Order</a></li>
                    <li><a href="{{URL::to('kitchen/orders/individual/report/'.$order->id)}}">Report</a></li>
                  </ul>
              </div>

                    </td>
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