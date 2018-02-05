
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

<div align="center"><strong>Summary report between {{$f}} and {{$t}}</strong></div><br>
    <table class="table tafter" border="1" cellspacing="0" cellpadding="0">


      <tr>
                  <td><strong>#</strong></td>
                  <td><strong>User</strong></td>
                  <td><strong>Total Orders</strong></td>
                  <td><strong>Cancelled Orders</strong></td>
                  <td><strong>Total Amount Held</strong></td>
                  

      </tr>

      <?php $i = 1; $orders=0; $pending=0; $completed=0; $cancelled=0; $paid=0; $unpaid=0; $total=0;?>
      @foreach($users as $user)
      <?php 
                  $orders = $orders + App\User::getRangeOrders($user->id,$from,$to);
                  $cancelled = $cancelled + App\User::getRangeCancelled($user->id,$from,$to);
                  $total = $total + App\User::getRangeAmount($user->id,$from,$to);
                ?>
      <tr>
                  <td>{{$i}}</td>
                  <td>{{$user->name}}</td>
                  <td>{{App\User::getRangeOrders($user->id,$from,$to)}}</td>
                  <td>{{App\User::getRangeCancelled($user->id,$from,$to)}}</td>
                  <td>{{number_format(App\User::getRangeAmount($user->id,$from,$to),2)}}</td>
                  
                  
                </tr>
                <?php $i++;?>
                @endforeach
                <tr>
                  
                  <td></td>
                  <td><strong>Total</strong></td>
                  <td><strong>{{$orders}}</strong></td>
                  <td><strong>{{$cancelled}}</strong></td>
                  <td><strong>{{number_format($total,2)}}</strong></td>

                </tr>
     
    </table>
   
</div>

</body>

</html>



