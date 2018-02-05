
@extends('layouts.kitchen')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Orders
        <small>Report</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{URL::to('/')}}"><i class="fa fa-files-o"></i> Orders</a></li>
        <li class="active">Report</li>
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
              <h3 class="box-title">Report </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" target="_blank" method="POST" action="{{ url('/kitchen/orders/report') }}">
              {{ csrf_field() }}
              <div class="box-body">
                <p style="color: red">Please fill in the fields in *</p>

                <div class="form-group">
                <label>Date:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" style="width: 300px !important" readonly name="from" class="form-control pull-left datepicker">
                </div>
                <!-- /.input group -->
              </div>

              <div class="form-group">
                <label>Date:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" style="width: 300px !important" readonly name="to" class="form-control pull-left datepicker">
                </div>
                <!-- /.input group -->
              </div>

                <div class="form-group">
                <label>Report Type <span style="color: red">*</span></label><br>
                <select class="form-control select2" style="width: 30%;" required="" name="type">
                  <option value=""></option>
                  <option value="excel">Excel</option>
                  <option value="pdf">PDF</option>
                </select>
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
