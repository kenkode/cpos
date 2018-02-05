
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
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Orders</h3>
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
            <a class="btn btn-warning btn-sm" href="{{ URL::to('cashier/orders/report')}}">Report</a>
            <br><br>
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Order #</th>
                  <th>Date</th>
                  <th>Ordered items</th>
                  <th>Total Amount</th>
                  <th>Order Status</th>
                  <th>Payment Status</th>
                  <th>Payment Method</th>
                  <th>Transaction Number</th>
                  <th>Amount Paid</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; $total = 0; $quantity=0;?>
                @foreach($orders as $order)
                @if($order->is_cancelled == 0)
                <?php 
                $total = $total + App\Orderitem::getAmount($order->id); 
                $quantity = $quantity + App\Orderitem::getQuantity($order->id);
                ?>
                <tr>
                  <td>{{$i}}</td>
                  <td>{{$order->order_no}}</td>
                  <td>{{$order->created_at->format('Y-m-d')}}</td>
                  <td>{{App\Orderitem::getQuantity($order->id)}}</td>
                  <td>{{number_format(App\Orderitem::getAmount($order->id),2)}}</td>
                  @if($order->is_complete == 1)
                  <td><span class="label label-success">Complete</span></td>
                  @elseif($order->is_cancelled == 1)
                  <td><span class="label label-danger">Cancelled</span></td>
                  @elseif($order->is_cancelled == 0 && $order->is_complete == 0)
                  <td><span class="label label-warning">Pending</span></td>
                  @endif

                  @if($order->is_paid == 1)
                  <td><span class="label label-success">Paid</span></td>
                  @else
                  <td><span class="label label-danger">Not Paid</span></td>
                  @endif
                  <td>{{$order->payment_method}}</td>
                  <td>{{$order->transaction_number}}</td>
                  <td>{{number_format($order->amount_paid,2)}}</td>
                  <td>
                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('cashier/order/show/'.$order->id)}}">View</a></li>
                    <li><a href="{{URL::to('receipt/'.$order->id)}}" target="_blank">Print Receipt</a></li>
                    @if($order->is_cancelled == 0 && $order->is_paid == 0)
                    <li><a href="{{URL::to('cashier/order/transact/'.$order->id)}}" >Complete Transaction</a></li>
                    @elseif($order->is_paid == 1)
                    <li><a href="{{URL::to('cashier/order/reverse/'.$order->id)}}" onclick="return (confirm('Are you sure you want to reverse this transaction?'))">Reverse Transaction</a></li>
                    @endif
                    <li><a href="{{URL::to('cashier/orders/individual/report/'.$order->id)}}">Report</a></li>
                  </ul>
              </div>

                    </td>
                </tr>
                <?php $i++;?>
                @endif
                @endforeach
                </tbody>
               
               <tfoot>
                   
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{$quantity}}</td>
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