
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

        <td style="width:200px;">
          <br>
          <h1>
          <strong>
          {{ strtoupper($organization->name)}}
          </strong></h1><br>
         
          {!! $organization->address !!}

        </td>
        

      </tr>



    </table>
   </div>

<br/>


  <div class="content" style='margin-top:-70px;'>

<div align="center"><strong>Organization : {{$organization->name}} </strong></div><br>
    <table class="table tafter" border="0" width="650" cellspacing="5" cellpadding="5">

      <tr>
        
        <td width="200"><strong>Photo : </strong></td>
        <td><img src="{{str_replace(' ','%20',asset('images/'.$organization->logo))}}" width="100" height="120" /></td>
       
        </tr>

        <tr>
        
        <td width="200"><strong>Name : </strong></td>
        <td>{{$organization->name}}</td>
       
        </tr>

        <tr>
        
        <td width="200"><strong>Address : </strong></td>
        <td>{{$organization->address}}</td>
       
        </tr>

        <tr>
        
        <td width="200"><strong>Tel # : </strong></td>
        <td>{{$organization->phone}}</td>
       
        </tr>

        <tr>
        
        <td width="200"><strong>KRA Pin : </strong></td>
        <td>{{$organization->pin}}</td>
       
        </tr>

        <tr>
        
        <td width="200"><strong>VAT # : </strong></td>
        <td>{{$organization->vat_no}}</td>
       
        </tr>

        <tr>
        
        <td width="200"><strong>VAT : </strong></td>
        <td>{{$organization->vat}}%</td>
       
        </tr>

        <tr>
        
        <td width="200"><strong>KRA/ETR : </strong></td>
        <td>{{$organization->kra_etr}}</td>
       
        </tr>

        <tr>
        
        <td width="200"><strong>Serial # : </strong></td>
        <td>{{$organization->serial_no}}</td>
       
        </tr>

        <tr>
        
        <td width="200"><strong>Foot note : </strong></td>
        <td>{{$organization->receipt_footer}}</td>
       
        </tr>

     
    </table>
   
</div>

</body>

</html>



