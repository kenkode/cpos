
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

<div align="center"><strong>Food : {{$food->name}} </strong></div><br>
    <table class="table tafter" border="1" width="650" cellspacing="0" cellpadding="10">

      <tr>
        
        <td width="200"><strong>Image : </strong></td>
        <td><img src="{{str_replace(' ','%20',asset('images/'.$food->image))}}" width="100" height="100" /></td>
       
        </tr>

        <tr>
        
        <td width="200"><strong>Name : </strong></td>
        <td>{{$food->name}}</td>
       
        </tr>

        <tr>
        
        <td width="200"><strong>Category : </strong></td>
        <td>{{$food->foodcategory->name}}</td>
       
        </tr>

        <tr>
        
        <td width="200"><strong>Normal Price : </strong></td>
        <td>Ksh. {{number_format($food->normal,2)}}</td>
       
        </tr>

        <tr>
        
        <td width="200"><strong>Small Size Price : </strong></td>
        <td>Ksh. {{number_format($food->small,2)}}</td>
       
        </tr>

        <tr>
        
        <td width="200"><strong>Medium Size Price : </strong></td>
        <td>Ksh. {{number_format($food->medium,2)}}</td>
       
        </tr>

        <tr>
        
        <td width="200"><strong>Large Size Price : </strong></td>
        <td>Ksh. {{number_format($food->large,2)}}</td>
       
        </tr>

     
    </table>
   
</div>

</body>

</html>



