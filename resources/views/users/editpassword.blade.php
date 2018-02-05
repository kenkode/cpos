
@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User
        <small>Change Password</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{URL::to('users')}}"><i class="fa fa-users"></i>User</a></li>
        <li class="active">Password</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
          <!-- small box -->
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Update Password</h3>
            </div>

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
            <form role="form" method="POST" action="{{ url('/users/changepassword/'.$user->id) }}">
              {{ csrf_field() }}
              <div class="box-body">
                
                <div class="form-group">
                  <label for="exampleInputPassword1">New Password</label>
                  <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter New Password" style="width: 30%" required="" name="password">
                </div>
                
                
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          <!-- /.box -->
        </div>
        
          </div>
          <!-- /.box -->

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
  @stop