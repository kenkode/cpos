<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>
<html >



<head>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>



  </head>


  <body>
  <!-- <img src="{{ asset('public/uploads/logo/ADmzyppq2eza.png') }}" class="watermark"> -->
<div class="content">

<div class="row">
  <div class="col-lg-12">

  <?php

  $address = explode('/', $organization->address);

  ?>

      <table class="" >

          <tr>

            <td>

            <img src="{{str_replace(' ','%20',public_path().'/images/'.$organization->logo)}}" alt="logo" width="60" height="60" />
    
        </td>
          
            <td colspan="2">
            {{ strtoupper($organization->name.",")}}<br>
            {{ strtoupper($organization->phone.",")}}<br>
            {{ $organization->address}}<br>


            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            
            <td colspan="2" >
                <table class="demo" border="1" style="width:100%">
                  <tr>
                    <td>&nbsp;&nbsp;<strong>Invoice</strong></td>
                  </tr>
                  <tr>
                    <td>&nbsp;&nbsp;Invoice No.: {{$order->order_no}}<br>
                      Date: {{ date('m/d/Y', strtotime($order->created_at))}}<br>
                      
                    </td>
                  </tr>
                  <!-- <tr >
                    <td>Date</td><td>Invoice #</td>
                  </tr>
                  <tr>
                    <td>{{ date('m/d/Y', strtotime($order->created_at))}}</td><td>{{$order->order_no}}</td>
                  </tr> -->
                  
                </table>
            </td>
          </tr>

          
        
      </table>
 
      <br>
      <table border="1" class="demo" style="width:40%">
        <tr>
          <td>&nbsp;&nbsp;<strong>Bill To</strong></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;{{$name}},<br>
            {{$phone}},<br>
            {{$email}},<br>
            {{$addr}}.<br>
          </td>
        </tr>
      </table>
      <br><br>

          <table border="1" class="inv" style="width:100%">
          
           <tr>
            <td >Item</td>
            <td>Description</td>
            
            <td>Qty</td>
            <td>Price</td>
            <td>Total Amount</td>
          </tr>

          <?php $total = 0; $i=1;  $grandtotal=0;
         
         ?>
          @foreach($orderitems as $orderitem)

          <?php
            $amount = $orderitem['amount'] * $orderitem['quantity'];
            /*$total_amount = $amount * $orderitem['duration'];*/
            $total = $total + $orderitem->amount * $orderitem['quantity'];


            ?>
          <tr>
            <td >{{ $orderitem->food->name}}</td>
            <td>{{ $orderitem->food->foodcategory->name}}</td>
            
            <td>{{ $orderitem->quantity}}</td>
            <td>{{ asMoney($orderitem->amount)}}</td>
            <td>{{ asMoney($orderitem['amount'] * $orderitem['quantity'])}}</td>
          </tr>


      @endforeach
      <!-- @for($i=1; $i<15;$i++)
       <tr>
            <td>&nbsp;</td>
            <td></td>
            <td> </td>
            <td> </td>
            <td> </td>
            
          </tr>
          @endfor -->
          <tr>
            <td rowspan="4" colspan="3">&nbsp;</td>
            
            <td ><strong>Total Amount</strong> </td><td colspan="1">KES {{asMoney($total)}}</td></tr>

            
<?php 
$grandtotal = $grandtotal + $total;


 ?>
            <?php $grandtotal = $total/*+ $txorder->amount*/;?>
           <tr>
            <td ><strong>VAT</strong> 16 %</td><td colspan="1">KES {{asMoney(0.16 * $total)}}</td>
           </tr>
            <tr>
            <td ><strong>Amount Payable</strong> </td><td colspan="1">KES {{asMoney($total + (0.16 * $total) )}}</td>
           </tr>
           
         


      
      </table>



    
  </div>


</div>
</div>
   

</body>

</html>



