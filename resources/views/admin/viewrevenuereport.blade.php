
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

<br/>


  <div class="content" style='margin-top:-70px;'>

<div align="center"><strong>Revenues </strong></div><br>
    <table class="table tafter" border="1" width="450" cellspacing="0" cellpadding="0">

      <tr>
        <th>#</th>
        <th>Order No.</th>
        <th>Amount</th>
        <th>Revenue</th>
        <th>Tax</th>
      </tr>
      <?php $i=1; $total = 0; $totalrevenue = 0; $totaltax = 0;?>
      @foreach($orders as $order)
      <?php 
        $total = $total + App\Orderitem::getAmount($order->id); 
        $totalrevenue = $totalrevenue + (App\Orderitem::getAmount($order->id) - (App\Orderitem::getAmount($order->id) * 0.16)); 
        $totaltax = $totaltax + (App\Orderitem::getAmount($order->id) * 0.16); 
      ?>
      <tr>
        <td>{{$i}}</td>
        <td>{{$order->order_no}}</td>
        <td>{{number_format(App\Orderitem::getAmount($order->id),2)}}</td>
        <td>{{number_format(App\Orderitem::getAmount($order->id) - (App\Orderitem::getAmount($order->id) * 0.16), 2)}}</td>
        <td>{{number_format((App\Orderitem::getAmount($order->id) * 0.16), 2)}}</td>
      </tr>
      <?php $i++; ?>
    @endforeach
    <tr>
      <td></td>
      <td></td>
      <td><strong>{{number_format($total,2)}}</strong></td>
      <td><strong>{{number_format($totalrevenue,2)}}</strong></td>
      <td><strong>{{number_format($totaltax,2)}}</strong></td>
    </tr>
    </table>
   
</div>

</body>

</html>



