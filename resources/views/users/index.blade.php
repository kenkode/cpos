
@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users
        <small>System Users</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-cutlery"></i> Users</li>
      </ol>
    </section>

    <!-- Main content -->
      <!-- Small boxes (Stat box) -->
      <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Users</h3>
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
            <a class="btn btn-info btn-sm" href="{{ URL::to('users/create')}}">new user</a>
            <a class="btn btn-warning btn-sm" href="{{ URL::to('users/report')}}">Report</a>
            <br><br>
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1;?>
                @foreach($users as $user)
                <tr>
                  <td>{{$i}}</td>
                  <td><img src="{{asset('images/'.$user->photo)}}" width="80" height="50" /></td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  @if($user->role == 'waiter')
                  <td>Cashier</td>
                  @else
                  <td>Admin</td>
                  @endif
                  @if($user->status == 1)
                  <td>Active</td>
                  @else
                  <td>Disabled</td>
                  @endif
                  <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('users/show/'.$user->id)}}">View</a></li>
                    @if($user->status == 1)
                    <li><a href="{{URL::to('users/deactivate/'.$user->id)}}">Deactivate</a></li>
                    @else
                    <li><a href="{{URL::to('users/activate/'.$user->id)}}">Activate</a></li>
                    @endif
                    <li><a href="{{URL::to('users/changepassword/'.$user->id)}}">Update Password</a></li>
                    <li><a href="{{URL::to('users/edit/'.$user->id)}}">Update User</a></li>
                    <li><a href="{{URL::to('users/individual/report/'.$user->id)}}">Report</a></li>
                    <li><a href="{{URL::to('users/delete/'.$user->id)}}" onclick="return (confirm('Are you sure you want to delete this user?'))">Delete</a></li>
                    
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
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
  @stop