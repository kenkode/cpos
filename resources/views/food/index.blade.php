
@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Food
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-cutlery"></i> Food</li>
      </ol>
    </section>

    <!-- Main content -->
      <!-- Small boxes (Stat box) -->
      <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Food</h3>
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
            <a class="btn btn-info btn-sm" href="{{ URL::to('food/create')}}">new food</a>
            <a class="btn btn-warning btn-sm" href="{{ URL::to('food/report')}}">Report</a>
            <br><br>
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Category</th>
                  <th>Normal Price (Ksh.)</th>
                  <th>Small Size Price (Ksh.)</th>
                  <th>Medium Size Price (Ksh.)</th>
                  <th>Large Size Price (Ksh.)</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1;?>
                @foreach($foods as $food)
                <tr>
                  <td>{{$i}}</td>
                  <td><img src="{{asset('images/'.$food->image)}}" width="50" height="50" /></td>
                  <td>{{$food->name}}</td>
                  <td>{{$food->foodcategory->name}}</td>
                  <td>{{number_format($food->normal,2)}}</td>
                  <td>{{number_format($food->small,2)}}</td>
                  <td>{{number_format($food->medium,2)}}</td>
                  <td>{{number_format($food->large,2)}}</td>
                  <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('food/show/'.$food->id)}}">View</a></li>
                    <li><a href="{{URL::to('food/edit/'.$food->id)}}">Update</a></li>
                    <li><a href="{{URL::to('food/individual/report/'.$food->id)}}">Report</a></li>
                    <li><a href="{{URL::to('food/delete/'.$food->id)}}" onclick="return (confirm('Are you sure you want to delete this food?'))">Delete</a></li>
                    
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