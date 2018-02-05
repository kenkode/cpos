
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

<div align="center"><strong>System Users </strong></div><br>
    <table class="table tafter" border="1" width="450" cellspacing="0" cellpadding="0">

      <tr>

        <td width="20"><strong># </strong></td>
        <td width="60"><strong>Photo </strong></td>
        <td width="150"><strong>Name </strong></td>
        <td width="150"><strong>Email </strong></td>
        <td><strong>Role </strong></td>
        <td><strong>Status </strong></td>

      </tr>
      <?php $i =1; ?>
      @foreach($users as $user)
      <tr>


       <td width="20">{{$i}}</td>
       <td width="60"><img src="{{str_replace(' ','%20',asset('images/'.$user->photo))}}" width="50" height="50" /></td>
       <td width="150">{{$user->name}}</td>
       <td width="150">{{$user->email}}</td>
       @if($user->role == 'waiter')
       <td>Cashier</td>
       @else
       <td>Admin</td>
       @endif
       @if($user->status == 1)
       <td>Active</td>
       @else
       <td>Disabled</td>
       @endif
        </tr>
      <?php $i++; ?>
   
    @endforeach

     
    </table>
   
</div>

</body>

</html>



