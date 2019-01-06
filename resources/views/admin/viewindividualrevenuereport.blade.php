
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

<div align="center"><strong>Order - {{$order->order_no}} Revenue</strong></div><br>
    <table class="table tafter" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td>Order No:</td>
        <td>{{$order->order_no}}</td>
      </tr>
      <tr>
        <td>Amount:</td>
        <td>{{number_format(App\Orderitem::getAmount($order->id),2)}}</td>
      </tr>
      <tr>
        <td>Revenue:</td>
        <td>{{number_format(App\Orderitem::getAmount($order->id) - (App\Orderitem::getAmount($order->id) * 0.16), 2)}}</td>
      </tr>
      <tr>
        <td>Tax:</td>
        <td>{{number_format((App\Orderitem::getAmount($order->id) * 0.16), 2)}}</td>
      </tr>
    </table>
   
</div>

</body>

</html>



