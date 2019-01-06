
@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Revenues
        <small>Show</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{URL::to('/revenues')}}"><i class="fa fa-money"></i> Revenues</a></li>
        <li class="active">Show</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
          <!-- small box -->
          <!-- general form elements -->
          <div class="box box-primary"  style="height: 450px">
            <div class="box-header with-border">
              <h3 class="box-title">Show </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div style="margin-left: 10px;">
            <br>
            <a class="btn btn-success btn-sm" href="{{ URL::to('revenues/individual/report/'.$order->id)}}">Report</a>
            <br><br>
            <table border="1" class="table table-bordered table-hover">
              <tr>
                <td>Order No:</td>
                <td>{{$order->order_no}}</td>
              </tr>
              <tr>
                <td>Amount:</td>
                <td>{{number_format(App\Orderitem::getAmount($order->id),2)}}</td>
              </tr>
              <tr>
                <td>Revenue:</td>
                <td>{{number_format(App\Orderitem::getAmount($order->id) - (App\Orderitem::getAmount($order->id) * 0.16), 2)}}</td>
              </tr>
              <tr>
                <td>Tax:</td>
                <td>{{number_format((App\Orderitem::getAmount($order->id) * 0.16), 2)}}</td>
              </tr>
              
            </table>
          </div>
          <!-- /.box -->
        </div>
        
          </div>
          <!-- /.box -->

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
  @stop
