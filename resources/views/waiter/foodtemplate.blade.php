
@extends('layouts.waiter')
@section('content')

<?php
require public_path()."/jcart-1.3/jcart/jcart.php";
?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$foodcategory->name}}
        <small>View Menu</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Food</li>
      </ol>
      
    </section>

    <!-- Main content -->
    <br />
    <section class="container">
        <div class="row">
            <div class="col-md-8" style="width: 700px !important">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background: #2389bb; color: #fff">
                        Menu
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <!-- BEGIN PRODUCTS -->
                            @if(count($foods) == 0)
                            <div class="col-md-12">
                            <h2 align="center">No Meals found</h2>
                            </div>
                            @else
                            <div class="col-md-12">
                            <?php $i =0; ?>
                            @foreach($foods as $food)
                            <script type="text/javascript">
                            function capitalize(s)
                            {
                                return s && s[0].toUpperCase() + s.slice(1);
                            }
                            $(document).ready(function(){
                            $('#product_size_'+<?php echo $i; ?>).change(function(){
                            $.ajax({
                                url: "{{URL::to('getprices')}}",
                                data: { 
                                      "value": $("#product_size_"+<?php echo $i; ?>).val(),
                                      "id": $("#product_id_"+<?php echo $i; ?>).val()
                                      },
                                type: "post",
                                success: function(data){
                                   $('#price_'+<?php echo $i; ?>).html('KSH'+parseFloat(data).toFixed(2)); 
                                   $("#product_price_"+<?php echo $i; ?>).val(data)
                                   $("#product_desc_"+<?php echo $i; ?>).html("Size : "+capitalize($("#product_size_"+<?php echo $i; ?>).val()));
                                   $("#size_"+<?php echo $i; ?>).val($("#product_size_"+<?php echo $i; ?>).val());
                                   $("#food_id_"+<?php echo $i; ?>).val($("#product_size_"+<?php echo $i; ?>).val()+{{$food->id}});
                                   //alert(data);
                                }
                            });
                            });
                            });
                        </script>
                            <div class="col-md-4 col-sm-6">
                                <div class="sc-product-item thumbnail">
                                    <img data-name="product_image" style="height: 130px !important;width: 200px !important" src="{{asset('images/'.$food->image)}}" alt="...">
                                    <form method="post" action="" class="jcart">
                    <fieldset>
                        <input type="hidden" name="jcartToken" value="<?php echo $_SESSION['jcartToken'];?>" />
                        <input type="hidden" id="{{'product_id_'.$i}}" value="{{$food->id}}" />
                        <input type="hidden" id="{{'food_id_'.$i}}" name="my-item-id" value="{{$food->id}}" />
                        <input type="hidden" name="my-item-name" value="{{$food->name}}" />
                        <input type="hidden" id="{{'product_price_'.$i}}" name="my-item-price" value="{{$food->normal}}" />
                        <input type="hidden" name="my-item-url" value="{{asset('images/'.$food->image)}}" />
                        <input type="hidden" name="my-item-size" id="{{'size_'.$i}}" value="normal" />

                        <div class="caption" style="height:300px !important">
                            <h4 style="font-size: 16px;" data-name="product_name">{{$food->name}}</h4>
                            <hr class="line">
                            <div class="form-group">
                                <label>Size: </label>
                                <select name="product_size" id="{{'product_size_'.$i}}" class="form-control input-sm">
                                <option value="normal">Normal</option>
                                <option value="small">Small</option>
                                <option value="medium">Medium</option>
                                <option value="large">Large</option>
                                </select>
                            </div>
                            <div class="form-group2">
                                <label>Qty: <input type="number" class="sc-cart-item-qty" name="my-item-qty" value="1" min="1" /></label>
                            </div><br>
                            
                            <label>Price: </label><br>
                            <strong class="price pull-left" id="{{'price_'.$i}}">KSH{{number_format($food->normal,2)}}</strong>    
                            
                        </div>
                        
                        <input type="submit" class="sc-add-to-cart btn btn-success btn-sm pull-right" name="my-add-button" value="add to cart" class="button" />
                    </fieldset>
                </form>


                <div class="clear"></div>

                                    
                                </div>
                            </div>
                            @if ($i % 5 == 0 && $i !=0)
                        </div>
                        <div class="col-md-12">
                        @endif
                        <?php $i++;?>
                    @endforeach
                    </div>
                    
                    @endif
                            
                            <!-- END PRODUCTS -->
                        </div>
                    </div>
                </div>
                
            </div>
            
            <aside class="col-lg-4 col-md-4 col-sm-12" style="width:450px !important; margin-left: -15px">
                
                <!-- Cart submit form -->
                <!-- <form action="{{URL::to('results')}}" method="POST" > 
                    {{ csrf_field() }}
                    <!-- SmartCart element -->
                    <!-- <div id="smartcart"></div>
                </form> -->

                <div id="jcart"><?php $jcart->display_cart();?></div>
                
            </aside>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @stop