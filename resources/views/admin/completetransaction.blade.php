
@extends('layouts.admin')
@section('content')

<script type="text/javascript">
  $(document).ready(function(){
    $(".transaction_number").hide();
    $(".payment_mode_div").hide();
    $(".amount_div").hide();
    $(".transaction_number_1").hide();
    $(".transaction_number_2").hide();
    $("#mode").on("change", function(){
        if($(this).val() != "Cash" && $(this).val() != "Double Payment"){
            $(".transaction_number").show();
        }else if($(this).val() == "Double Payment"){
            $(".transaction_number").hide();
            $(".payment_mode_div").show();
            $(".amount_div").show();
        }else{
            $(".transaction_number").hide();
            $(".payment_mode_div").hide();
            $(".amount_div").hide();
        }
    });
    $("#mode_1").on("change", function(){
        if($(this).val() != "Cash"){
            $(".transaction_number_1").show();
        }else{
            $(".transaction_number_1").hide();
        }
    });

    $('body').on("keyup","#amount_1",function(){
      alert()
        $('#amount_2').val($('#total').val() - $('#amount_1').val());
    })

    $('body').on('keyup','#amount_2',function(){
        $('#amount_1').val($('#total').val() - $('#amount_2').val());
    })

    $("#mode_2").on("change", function(){
        if($(this).val() != "Cash"){
            $(".transaction_number_2").show();
        }else{
            $(".transaction_number_2").hide();
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
            <form role="form" method="POST" action="{{ url('/admin/orders/payments/store') }}" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="box-body">
                <p style="color: red">Please fill in the fields in *</p>

                <div class="form-group">
                  <label for="exampleInputEmail1">Order</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" disabled="" style="width: 30%" value="{{$order->order_no." - amount (Ksh. ".number_format($order->amount,2).")"}}">
                  <input type="hidden" value="{{$order->id}}" name="order">
                </div>

                <input type="hidden" id="total" value="{{$order->amount}}">

                <div class="form-group">
                  <label for="exampleInputEmail1">Mode of Payment <span style="color: red">*</span></label><br>
                  <select class="form-control select2" style="width: 30%;" required="" name="mode" id="mode">
                    <option value="Cash">Cash</option>
                    <option value="Mpesa">Mpesa</option>
                    <option value="Bank">Bank</option>
                    <option value="Double Payment">Double Payment</option>
                  </select>
                </div>

                <div class="form-group payment_mode_div">
                  <label for="exampleInputEmail1">Mode of Payment <span style="color: red">*</span></label><br>
                  <select class="form-control select2" style="width: 30%;" required="" name="mode_1" id="mode_1">
                    <option value="Cash">Cash</option>
                    <option value="Mpesa">Mpesa</option>
                    <option value="Bank">Bank</option>
                   </select>
                </div>

                <div class="form-group transaction_number_1">
                  <label for="exampleInputEmail1">Transaction Number</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Transaction Number" style="width: 30%" value="{{old('transaction_number_1')}}" name="transaction_number_1">
                </div>

                <div class="form-group amount_div">
                  <label for="exampleInputEmail1">Amount</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Amount" style="width: 30%" value="{{old('amount_1')}}" name="amount_1" id="amount_1">
                </div>

                <div class="form-group payment_mode_div">
                  <label for="exampleInputEmail1">Mode of Payment <span style="color: red">*</span></label><br>
                  <select class="form-control select2" style="width: 30%;" required="" name="mode_2" id="mode_2">
                    <option value="Cash">Cash</option>
                    <option value="Mpesa">Mpesa</option>
                    <option value="Bank">Bank</option>
                   </select>
                </div>

                <div class="form-group transaction_number_2">
                  <label for="exampleInputEmail1">Transaction Number</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Transaction Number" style="width: 30%" value="{{old('transaction_number_2')}}" name="transaction_number_2">
                </div>

                <div class="form-group amount_div">
                  <label for="exampleInputEmail1">Amount</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Amount" style="width: 30%" value="{{old('amount_2')}}" name="amount_2" id="amount_2">
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
