
<html >



<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
body{
  font-size: 8px;
}
</style>


</head>

<body>

  <div class="header" style="margin-top:-150px; background: #ffffff !important">
     <table class="tpage" style="background: #ffffff !important">

      <tr>


       
        <td style="width:100px">

            <img src="{{str_replace(' ','%20',public_path().'/images/'.$organization->logo)}}" alt="logo" />

    
        </td>

        <td style="width:100px;">
          <br>
          <h1>
        <strong>
          {{ strtoupper($organization->name)}}
          </strong>
       </h1>

        </td>
        

      </tr>



    </table>
   </div>

<br/>


  <div class="content" style='margin-top:-70px;'>

<div align="center"><strong>Orders report between {{$f}} and {{$t}}</strong></div><br>
    <table class="table tafter" border="1" cellspacing="0" cellpadding="0">

      <tr>
                  <td><strong>#</strong></td>
                  <td><strong>Order No.</strong></td>
                  <td><strong>Date</strong></td>
                  <td><strong>Amount</strong></td>
                  <td><strong>Payment Method</strong></td>
                  <td><strong>Transaction Number</strong></td>
                  <td><strong>Status</strong></td>
                  <td><strong>Paid</strong></td>
                  <td><strong>Transacted By</strong></td>
                  <td><strong>Reversed By</strong></td>
                  <td><strong>Payment By</strong></td>
      </tr>
      <?php $i=1; $total = 0;?>
                @foreach($orders as $order)
                <?php $total = $total + App\Orderitem::getAmount($order->id); ?>
                <tr>
                  <td>{{$i}}</td>
                  <td>{{$order->order_no}}</td>
                  <td>{{$order->created_at->format('d-M-Y')}}</td>
                  <td>{{number_format(App\Orderitem::getAmount($order->id),2)}}</td>
                  <td>{{$order->payment_method}}</td>
                  <td>{{$order->transaction_number}}</td>
                  @if($order->is_complete == 1)
                  <td><span class="label label-success">Complete</span></td>
                  @elseif($order->is_cancelled == 1)
                  <td><span class="label label-danger">Cancelled</span></td>
                  @elseif($order->is_cancelled == 0 && $order->is_complete == 0)
                  <td><span class="label label-warning">Pending</span></td>
                  @else
                  <td><span class="label label-success">Complete</span></td>
                  @endif

                  @if($order->is_paid == 1)
                  <td><span class="label label-success">Paid</span></td>
                  @elseif($order->is_paid == 0 && $order->is_cancelled == 0)
                  <td><span class="label label-danger">Not Paid</span></td>
                  @else
                  <td><span class="label label-danger">Reversed</span></td>
                  @endif    

                  <td>{{App\User::getUser($order->waiter_id)}}</td>
                  
                  @if($order->is_cancelled == 1)
                  <td>{{App\User::getUser($order->cancel_id)}}</td>
                  @else
                  <td></td>
                  @endif
                  <td>{{App\User::getUser($order->payment_by) ? App\User::getUser($order->payment_by) : ""}}</td>
                  
                </tr>
                <?php $i++;?>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>{{number_format($total,2)}}</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
     
    </table>
   
</div>

</body>

</html>



