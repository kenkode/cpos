
@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Summary
        <small>Users Summary</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Summary</li>
      </ol>
    </section>

    <!-- Main content -->
    <br />
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">{{$user->name}} Summary</h3>
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
            <a class="btn btn-warning btn-sm" href="{{URL::to('admin/user/summary/report/'.$user->id)}}">Report</a>
            <br><br>
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Waiter</th>
                  <th>Completed Orders</th>
                  <th>Cancelled Orders</th>
                  <th>Total Orders</th>
                  <th>Total Amount Held</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; $orders=0; $pending=0; $completed=0; $cancelled=0; $paid=0; $unpaid=0; $total=0;?>
                <?php 
                  $orders = $orders + App\User::getOrders($user->id);
                  $completed = $completed + App\User::getCompleted($user->id);
                  $cancelled = $cancelled + App\User::getCancelled($user->id);
                  $total = $total + App\User::getAmount($user->id);
                ?>
                <tr>
                  <td>{{$user->name}}</td>
                  <td>{{App\User::getCompleted($user->id)}}</td>
                  <td>{{App\User::getCancelled($user->id)}}</td>
                  <td>{{App\User::getOrders($user->id)}}</td>
                  <td>{{number_format(App\User::getAmount($user->id),2)}}</td>
                  
                  
                </tr>
                
                </tbody>

                <tfoot>
                  
                  <td></td>
                  <td>{{$completed}}</td>
                  <td>{{$cancelled}}</td>
                  <td>{{$orders}}</td>
                  <td>{{number_format($total,2)}}</td>

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