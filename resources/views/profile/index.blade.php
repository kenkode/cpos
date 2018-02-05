@extends('layouts.waiter')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profile
        <small>My Profile</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
          <!-- small box -->
          <!-- general form elements -->
          <div class="box box-primary" style="height: 450px">
            <div class="box-header with-border">
              <h3 class="box-title">Profile</h3>
            </div>
            
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
            <table border="1" class="table table-bordered table-hover" style="margin-left: 10px">
              <div class="box-body">
                <tr>
                <td>Image:</td>
                <td><img src="{{asset('images/'.Auth::user()->photo)}}" width="80" height="60" /></td>
              </tr>
              <tr>
                <td>Name:</td>
                <td>{{Auth::user()->name}}</td>
              </tr>
              <tr>
                <td>Email:</td>
                <td>{{Auth::user()->email}}</td>
              </tr>
              <tr>
                <td>Role:</td>
                <td>{{Auth::user()->role}}</td>
              </tr>
                
              <!-- /.box-body -->

              <tr style="height: 40px;">
                <td>
                <a href="{{URL::to('/user/profile/edit')}}" style="margin-left: 3px;"><button type="submit" class="btn btn-primary">Edit Profile</button></a>
              </td>
              <td>
                <a href="{{URL::to('/user/password')}}" style="margin-left: 3px;"><button type="submit" class="btn btn-success">Change Password</button></a>
              </td>
            </tr>
            </table>
          <!-- /.box -->
        </div>
        
          </div>
          <!-- /.box -->

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
  @stop