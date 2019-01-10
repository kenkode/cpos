
<html >



<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>



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


  <div class="content" style='margin-top:-70px;'>

<div align="center"><strong>Payments report between {{$f}} and {{$t}}</strong></div><br>
    <table class="table tafter" border="1" cellspacing="0" cellpadding="0">

      <tr>
                  <td><strong>#</strong></td>
                  <td><strong>Order No.</strong></td>
                  <td><strong>Date</strong></td>
                  <td><strong>Amount</strong></td>
                  <td><strong>Payment Method</strong></td>
                  <td><strong>Transaction Number</strong></td>
                  <td><strong>Amount Paid</strong></td>
                  <td><strong>Transacted By</strong></td>

      </tr>
      <?php $i=1; $total = 0;?>
                @foreach($orders as $order)
                <?php $total = $total + App\Orderitem::getAmount($order->id); ?>
                <tr>
                  <td>{{$i}}</td>
                  <td>{{$order->order_no}}</td>
                  <td>{{$order->created_at->format('Y-m-d')}}</td>
                  @if($order->is_paid == 0 && $order->is_cancelled == 0)
                  <td style="color:red;"><strong>Not Paid</strong></td>
                  @elseif($order->is_cancelled == 1)
                  <td style="color:red;"><strong>Reversed</strong></td>
                  @else
                  <td>{{number_format(App\Orderitem::getAmount($order->id),2)}}</td>
                  @endif
                  <td>{{$order->payment_method}}</td>
                  <td>{{$order->transaction_number}}</td>
                  <td>{{number_format($order->amount_paid,2)}}</td>
                  <td>{{App\User::getUser($order->waiter_id)}}</td>
                  
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
              
                </tr>
     
    </table>
   
</div>

</body>

</html>



