
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

<div align="center"><strong>Order : {{$order->order_no}}<br> @if(App\Order::getOrder($id)->is_cancelled == 1)
                  Status: Cancelled
                  @else
                  Status: Complete
                  @endif
                <br>
            Payment by: {{App\User::getUser(App\Order::getOrder($id)->payment_by) ? App\User::getUser(App\Order::getOrder($id)->payment_by) : ""}}
          </strong></div><br>
    <table class="table tafter" border="1" cellspacing="0" cellpadding="0">

      <tr>
                  <td><strong>#</strong></td>
                  <td><strong>Image</strong></td>
                  <td><strong>Name</strong></td>
                  <td><strong>Category</strong></td>
                  <td><strong>Size</strong></td>
                  <td><strong>Date</strong></td>
                  <td><strong>Quantity</strong></td>
                  <td><strong>Amount</strong></td>
                  <td><strong>Total</strong></td>
                  <td><strong>Status</strong></td>

      </tr>
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
                  <td><img src="{{str_replace(' ','%20', asset('/images/'.App\Food::getFood($orderitem->food_id)->image))}}" width="50" height="50" /></td>
                  <td>{{App\Food::getFood($orderitem->food_id)->name}}</td>
                  <td>{{App\Foodcategory::getName($orderitem->food_id)}}</td>
                  <td>{{$orderitem->size}}</td>
                  <td>{{$orderitem->created_at->format('Y-m-d')}}</td>
                  <td>{{$orderitem->quantity}}</td>
                  <td>{{number_format($orderitem->amount,2)}}</td>
                  <td>{{number_format($orderitem->amount * $orderitem->quantity,2)}}</td>
                  @if(App\Order::getOrder($id)->is_cancelled == 1)
                  <td><span class="label label-danger">Reversed</span></td>
                  @else
                  <td><span class="label label-success">Complete</span></td>
                  @endif
                  
                </tr>
                <?php $i++;?>
                @endforeach
                <tr>
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
                </tr>
     
    </table>
   
</div>

</body>

</html>



