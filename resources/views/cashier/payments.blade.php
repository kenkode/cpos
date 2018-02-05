
@extends('layouts.cashier')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Orders
        <small>Transactions</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{URL::to('/admin/orders')}}"><i class="fa fa-shopping-cart"></i>Orders</a></li>
        <li class="active">Transactions</li>
      </ol>
    </section>

    <!-- Main content -->
    <br />
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Ordered Meals</h3>
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
            <br><br>
            <h4 style="color: green"><strong>Order Number: {{App\Order::getOrder($id)->order_no}}</strong></h4>
            
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Category</th>
                  <th>Size</th>
                  <th>Date</th>
                  <th>Quantity</th>
                  <th>Amount</th>
                  <th>Total</th>
                  <th>Status</th>
                  
                </tr>
                </thead>
                <tbody>
                <?php $i=1; $quantity=0; $amount=0; $total=0;?>
                @foreach($orderitems as $orderitem)
                @if($orderitem->is_cancelled == 0)
                <?php
                 $quantity = $quantity + $orderitem->quantity;
                 $amount   = $amount   + $orderitem->amount;
                 $total    = $total    + ($orderitem->quantity * $orderitem->amount);
                ?>
                @endif
                <tr>
                  <td>{{$i}}</td>
                  <td><img src="{{asset('images/'.App\Food::getFood($orderitem->food_id)->image)}}" width="50" height="50" /></td>
                  <td>{{App\Food::getFood($orderitem->food_id)->name}}</td>
                  <td>{{App\Foodcategory::getName($orderitem->food_id)}}</td>
                  <td>{{$orderitem->size}}</td>
                  <td>{{$orderitem->created_at->format('Y-m-d')}}</td>
                  <td>{{$orderitem->quantity}}</td>
                  <td>{{number_format($orderitem->amount,2)}}</td>
                  <td>{{number_format($orderitem->amount * $orderitem->quantity,2)}}</td>
                  @if(App\Order::getOrder($id)->is_complete == 1)
                  <td><span class="label label-success">Complete</span></td>
                  @elseif($orderitem->is_cancelled == 1)
                  <td><span class="label label-danger">Cancelled</span></td>
                  @elseif($orderitem->is_cancelled == 0 && App\Order::getOrder($id)->is_complete == 0)
                  <td><span class="label label-warning">Pending</span></td>
                  @endif
              
                </tr>
                <?php $i++;?>
                @endforeach
                </tbody>

                <tfoot>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>{{$quantity}}</strong></td>
                    <td><strong>{{number_format($amount,2)}}</strong></td>
                    <td><strong>{{number_format($total,2)}}</strong></td>
                    <td></td>
                    
                </tfoot>
               
              </table>
            
          <!-- /.box -->

        <form role="form" method="POST" action="{{ url('/cashier/order/transact/'.$id) }}">
              {{ csrf_field() }}
              <div class="box-body">
                <p style="color: red">Please fill in the fields in *</p>
                <div class="form-group">
                <label>Payment Method <span style="color: red">*</span></label><br>
                <select class="form-control select2" style="width: 30%;" required="" name="payment_method">
                  <option value="Cash">Cash</option>
                  <option value="Paybill">Till Number</option>
                  <option value="Bank">Atm Card</option>
                </select>
              </div>

              <div class="form-group">
                  <label for="exampleInputEmail1">Transaction No. (if Till number/ Atm Card is used)</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter transaction number" style="width: 30%" value="{{old('trans_no')}}" name="trans_no">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Amount Paid <span style="color: red">*</span></label>
                  <div class="input-group">
                  <span class="input-group-addon">KES</span>
                  <input type="text" class="form-control" id="amount" placeholder="Enter amount paid" style="width: 27%" value="{{old('amount')}}" name="amount" required="">
                  <script type="text/javascript">
                   $(document).ready(function() {
                   $('#amount').priceFormat();
                   });
                  </script>
                </div>
                </div>
                
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>

        </div>
        
          </div>
          </div>

          </div>
          <!-- /.box -->

        </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @stop