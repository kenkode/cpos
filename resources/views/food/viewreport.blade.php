
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

<div align="center"><strong>Food </strong></div><br>
    <table class="table tafter" border="1" width="550" cellspacing="0" cellpadding="0">

      <tr>

        <td><strong>#</strong></td>
        <td><strong>Image</strong></td>
        <td><strong>Name</strong></td>
        <td><strong>Category</strong></td>
        <td><strong>Normal Price (Ksh.)</strong></td>
        <td><strong>Small Size Price (Ksh.)</strong></td>
        <td><strong>Medium Size Price (Ksh.)</strong></td>
        <td><strong>Large Size Price (Ksh.)</strong></td>

      </tr>
      <?php $i =1; ?>
      @foreach($foods as $food)
      <tr>

<td>{{$i}}</td>
                  <td><img src="{{str_replace(' ','%20',asset('images/'.$food->image))}}" width="50" height="50" /></td>
                  <td>{{$food->name}}</td>
                  <td>{{$food->foodcategory->name}}</td>
                  <td>{{number_format($food->normal,2)}}</td>
                  <td>{{number_format($food->small,2)}}</td>
                  <td>{{number_format($food->medium,2)}}</td>
                  <td>{{number_format($food->large,2)}}</td>
                  
        </tr>
      <?php $i++; ?>
   
    @endforeach

     
    </table>
   
</div>

</body>

</html>



