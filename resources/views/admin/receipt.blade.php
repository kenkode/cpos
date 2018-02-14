
<html >



<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<style>
body{
  font-size: 6px;
}
.content{
  margin-top: -70px !important;
}
</style>

</head>

<body>

  <div class="header" align="center">
          
          START LEGAL RECEIPT<br>
          {{ strtoupper($organization->name)}}<br>
          {{strtoupper($organization->address)}}<br>
          TEL#{{$organization->phone}}<br>
          PIN#{{$organization->pin}}<br>
          VAT#{{$organization->vat_no}}<br><br>
          


   </div>

<div class="content">
    <table border="0" width="300" cellspacing="0" cellpadding="3">

      <!-- <tr>
        <td width="227" colspan="5"><hr></td>
      </tr> -->
     
      <tr>
                  <td style="border-top: 1px dashed grey;border-bottom: 1px dashed grey" width="20"><strong>#</strong></td>
                  <td style="border-top: 1px dashed grey;border-bottom: 1px dashed grey" width="80"><strong>ITEM</strong></td>
                  <!-- <td style="border-top: 1px dashed grey;border-bottom: 1px dashed grey" width="30"><strong>QTY</strong></td>
                  <td style="border-top: 1px dashed grey;border-bottom: 1px dashed grey" width="60"><strong>PRICE</strong></td> -->
                  <td style="border-top: 1px dashed grey;border-bottom: 1px dashed grey" width="60"><strong>PRICE (KSH)</strong></td>

      </tr>
      
      <?php $i=1; $total = 0;?>
                @foreach($orderitems as $orderitem)
                @if($orderitem->is_cancelled == 0)
                <?php $total = $total + ($orderitem->amount * $orderitem->quantity); ?>
                <tr>
                  <td>{{$i}}</td>
                  <td>{{App\Food::getFood($orderitem->food_id)->name}}</td>
                 <!--  <td>{{$orderitem->quantity}}</td>
                  <td>{{number_format($orderitem->amount,2)}}</td> -->
                  <td>{{number_format($orderitem->amount * $orderitem->quantity,2)}}</td>
                </tr>
                <?php $i++;?>
                @endif
                @endforeach
                <tr>
                    <td colspan="2">TOTAL:</td><td>KSH {{number_format($total,2)}}</td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center">VAT RECEIPT ANALYSIS:</td>
                  </tr>
                  <tr>
                    <td colspan="2">V.A.T. A {{$organization->vat}} %</td><td>{{number_format(($organization->vat * $total)/100,2)}}</td>
                  </tr>
                  <tr>
                    <td colspan="2">V.A.T. TOTAL</td><td>{{number_format(($organization->vat * $total)/100,2)}}</td>
                  </tr>
                  @if($order->is_paid == 1)
                  <tr>
                    <td colspan="2">PAY CASH:</td><td>KSH {{number_format($order->amount_paid,2)}}</td>
                  </tr>
                  <tr>
                    <td colspan="2">CHANGE:</td><td>KSH {{number_format($order->amount_paid - $total,2)}}</td>
                  </tr>
                  @endif
                  <tr>
                    <td colspan="2">LEGAL RECEIPT:</td><td>{{$order->order_no}}</td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center">{{strtoupper($order->created_at->format('l d M.  Y H:i'))}}</td>
                  </tr>
                  <tr>
                    <td colspan="2">SERIAL NUMBER #:</td><td># {{$organization->serial_no}} #</td>
                  </tr>
                  <tr>
                    <td colspan="3"># KRA/ETR/{{$organization->kra_etr}} #:</td>
                  </tr>
     
    </table>

    <div align="center">END LEGAL RECEIPT</div>
    <div align="center">THANK YOU</div>
   
</div>
  
</body>

</html>



