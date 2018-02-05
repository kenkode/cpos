
@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Food Category
        <small>Show</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{URL::to('/food')}}"><i class="fa fa-cutlery"></i> Food</a></li>
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
            <a class="btn btn-info btn-sm" href="{{ URL::to('food/edit/'.$food->id)}}">Update</a>
            <a class="btn btn-warning btn-sm" href="{{ URL::to('food/')}}">Go Back</a>
            <a class="btn btn-danger btn-sm" href="{{ URL::to('food/delete/'.$food->id)}}" onclick="return (confirm('Are you sure you want to delete this food?'))">Delete</a>
            <a class="btn btn-success btn-sm" href="{{ URL::to('food/individual/report/'.$food->id)}}">Report</a>
            <br><br>
            <table border="1" class="table table-bordered table-hover">
              <tr>
                <td>Image:</td>
                <td><img src="{{asset('images/'.$food->image)}}" width="50" height="50" /></td>
              </tr>
              <tr>
                <td>Name:</td>
                <td>{{$food->name}}</td>
              </tr>
              <tr>
                <td>Category:</td>
                <td>{{$food->foodcategory->name}}</td>
              </tr>
              <tr>
                <td>Normal Price:</td>
                <td>Ksh. {{number_format($food->normal,2)}}</td>
              </tr>
              <tr>
                <td>Small Size Price:</td>
                <td>Ksh. {{number_format($food->small,2)}}</td>
              </tr>
              <tr>
                <td>Medium Size Price:</td>
                <td>Ksh. {{number_format($food->medium,2)}}</td>
              </tr>
              <tr>
                <td>Large Size Price:</td>
                <td>Ksh. {{number_format($food->large,2)}}</td>
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
