
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
        <li><i class="fa fa-cutlery"></i> Food</li>
        <li><a href="{{URL::to('/category')}}"><i class="fa fa-list"></i> Category</a></li>
        <li class="active">Show</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
          <!-- small box -->
          <!-- general form elements -->
          <div class="box box-primary"  style="height: 300px">
            <div class="box-header with-border">
              <h3 class="box-title">Show </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div style="margin-left: 10px;">
            <br>
            <a class="btn btn-info btn-sm" href="{{ URL::to('category/edit/'.$category->id)}}">Update</a>
            <a class="btn btn-warning btn-sm" href="{{ URL::to('category/')}}">Go Back</a>
            <a class="btn btn-danger btn-sm" href="{{ URL::to('category/delete/'.$category->id)}}" onclick="return (confirm('Are you sure you want to delete this food category?'))">Delete</a>
            <a class="btn btn-success btn-sm" href="{{ URL::to('category/individual/report/'.$category->id)}}">Report</a>
            <br><br>
            <table border="1" class="table table-bordered table-hover">
              <tr>
                <td>Name:</td>
                <td>{{$category->name}}</td>
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
