
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

  <div class="header" align="center">
          <strong>
          {{ strtoupper($organization->name)}}<br>
          {{$organization->address}}<br><br>
          Date & Time:{{$order->created_at}}<br>
          Order No:{{$order->order_no}}
          </strong>


   </div>

<br/>

<div class="content" style='margin-top:-70px;'>
    <table border="0" width="300" cellspacing="0" cellpadding="3">

      <!-- <tr>
        <td width="227" colspan="5"><hr></td>
      </tr> -->
     
      <tr>
                  <td style="border-top: 1px dashed grey;border-bottom: 1px dashed grey" width="20"><strong>#</strong></td>
                  <td style="border-top: 1px dashed grey;border-bottom: 1px dashed grey" width="80"><strong>ITEM</strong></td>
                  <td style="border-top: 1px dashed grey;border-bottom: 1px dashed grey" width="30"><strong>QTY</strong></td>
                  <td style="border-top: 1px dashed grey;border-bottom: 1px dashed grey" width="60"><strong>PRICE</strong></td>
                  <td style="border-top: 1px dashed grey;border-bottom: 1px dashed grey" width="60"><strong>TOTAL</strong></td>

      </tr>
      
      <?php $i=1; $total = 0;?>
                @foreach($orderitems as $orderitem)
                @if($orderitem->is_cancelled == 0)
                <?php $total = $total + ($orderitem->amount * $orderitem->quantity); ?>
                <tr>
                  <td>{{$i}}</td>
                  <td>{{App\Food::getFood($orderitem->food_id)->name}}</td>
                  <td>{{$orderitem->quantity}}</td>
                  <td>{{number_format($orderitem->amount,2)}}</td>
                  <td>{{number_format($orderitem->amount * $orderitem->quantity,2)}}</td>
                </tr>
                <?php $i++;?>
                @endif
                @endforeach
                <tr>
                    <td colspan="4"><strong>Total:</strong></td><td><strong>{{number_format($total,2)}}</strong></td>
                  </tr>
                  @if($order->is_paid == 1)
                  <tr>
                    <td colspan="4"><strong>Cash Paid:</strong></td><td><strong>{{number_format($order->amount_paid,2)}}</strong></td>
                  </tr>
                  <tr>
                    <td colspan="4"><strong>Change:</strong></td><td><strong>{{number_format($order->amount_paid - $total,2)}}</strong></td>
                  </tr>
                  @endif
                    
     
    </table>
   
</div>
  
</body>

</html>



