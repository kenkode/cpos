
@extends('layouts.waiter')
@section('content')

<script type="text/javascript">
  $(document).ready(function(){
  $(".transaction_number").hide();
  $("#mode").on("change", function(){
        if($(this).val() != "Cash"){
            $(".transaction_number").show();
        }else{
            $(".transaction_number").hide();
        }
    });
  });
</script>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Payment
        <small>Create</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{URL::to('/food')}}"><i class="fa fa-cutlery"></i> Payment</a></li>
        <li class="active">Create</li>
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
              <h3 class="box-title">Create </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ url('/waiter/orders/payments/store') }}" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="box-body">
                <p style="color: red">Please fill in the fields in *</p>

                <div class="form-group">
                  <label for="exampleInputEmail1">Order</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" disabled="" style="width: 30%" value="{{$order->order_no." - amount (Ksh. ".number_format($order->amount,2).")"}}">
                  <input type="hidden" value="{{$order->id}}" name="order">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Mode of Payment <span style="color: red">*</span></label><br>
                  <select class="form-control select2" style="width: 30%;" required="" name="mode" id="mode">
                    <option value="Cash">Cash</option>
                    <option value="Mpesa">Mpesa</option>
                    <option value="Bank">Bank</option>
                   </select>
                </div>

                <div class="form-group transaction_number">
                  <label for="exampleInputEmail1">Transaction Number</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Transaction Number" style="width: 30%" value="{{old('transaction_number')}}" name="transaction_number">
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
