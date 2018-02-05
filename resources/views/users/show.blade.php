
@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User
        <small>Show</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{URL::to('/users')}}"><i class="fa fa-users"></i> User</a></li>
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
            <a class="btn btn-info btn-sm" href="{{ URL::to('users/edit/'.$user->id)}}">Update User</a>
            <a class="btn btn-success btn-sm" href="{{ URL::to('users/changepassword/'.$user->id)}}">Update Password</a>
            @if($user->status == 1)
            <a class="btn btn-primary btn-sm" href="{{ URL::to('users/deactivate/'.$user->id)}}">Deactivate</a>
            @else
            <a class="btn btn-primary btn-sm" href="{{ URL::to('users/activate/'.$user->id)}}">Activate</a>
            @endif
            <a class="btn btn-warning btn-sm" href="{{ URL::to('users/')}}">Go Back</a>
            <a class="btn btn-danger btn-sm" href="{{ URL::to('users/delete/'.$user->id)}}" onclick="return (confirm('Are you sure you want to delete this user?'))">Delete</a>
            <a class="btn btn-success btn-sm" href="{{ URL::to('users/individual/report/'.$user->id)}}">Report</a>
            <br><br>
            <table border="1" class="table table-bordered table-hover">
              <tr>
                <td>Image:</td>
                <td><img src="{{asset('images/'.$user->photo)}}" width="80" height="60" /></td>
              </tr>
              <tr>
                <td>Name:</td>
                <td>{{$user->name}}</td>
              </tr>
              <tr>
                <td>Email:</td>
                <td>{{$user->email}}</td>
              </tr>
              <tr>
                <td>Role:</td>
                @if($user->role == 'waiter')
                <td>Cashier</td>
                @else
                <td>Admin</td>
                @endif
              </tr>
              <tr>
                <td>Status:</td>
                @if($user->status == 1)
                  <td>Active</td>
                  @else
                  <td>Disabled</td>
                  @endif
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
