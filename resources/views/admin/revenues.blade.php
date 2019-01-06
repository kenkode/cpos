
@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ordes
        <small>System Revenues</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Revenues</li>
      </ol>
    </section>

    <!-- Main content -->
    <br />
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Revenues</h3>
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
            <a class="btn btn-warning btn-sm" href="{{ URL::to('revenues/report')}}">Report</a>
            <br><br>
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Order No.</th>
                  <th>Amount</th>
                  <th>Revenue</th>
                  <th>Tax</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; $total = 0; $totalrevenue = 0; $totaltax = 0;?>
                @foreach($orders as $order)
                <?php 
                  $total = $total + App\Orderitem::getAmount($order->id); 
                  $totalrevenue = $totalrevenue + (App\Orderitem::getAmount($order->id) - (App\Orderitem::getAmount($order->id) * 0.16)); 
                  $totaltax = $totaltax + (App\Orderitem::getAmount($order->id) * 0.16); 
                ?>
                <tr>
                  <td>{{$i}}</td>
                  <td>{{$order->order_no}}</td>
                  <td>{{number_format(App\Orderitem::getAmount($order->id),2)}}</td>
                  <td>{{number_format(App\Orderitem::getAmount($order->id) - (App\Orderitem::getAmount($order->id) * 0.16), 2)}}</td>
                  <td>{{number_format((App\Orderitem::getAmount($order->id) * 0.16), 2)}}</td>
                  <td>
                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('revenues/show/'.$order->id)}}">View</a></li>
                    <li><a href="{{URL::to('revenues/individual/report/'.$order->id)}}">Report</a></li>
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
                    <td><strong>{{number_format($total,2)}}</strong></td>
                    <td><strong>{{number_format($totalrevenue,2)}}</strong></td>
                    <td><strong>{{number_format($totaltax,2)}}</strong></td>
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