
@extends('layouts.admin')
@section('content')

<style type="text/css">
  #imagePreview {
    width: 180px;
    height: 180px;
    background-position: center center;
    background-size: cover;
    -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
    display: inline-block;
}
</style>

<script type="text/javascript">
  $(document).ready(function(){
  $("#uploadFile").on("change", function()
    {
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
        
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
            
            reader.onloadend = function(){ // set image data as background of div
                $("#imagePreview").css("background-image", "url("+this.result+")");
            }
            }
    });
  });
</script>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Food
        <small>Create</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{URL::to('/food')}}"><i class="fa fa-cutlery"></i> Food</a></li>
        <li class="active">Create</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
          <!-- small box -->
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Create </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ url('/food/store') }}" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="box-body">
                <p style="color: red">Please fill in the fields in *</p>
                <div class="form-group">
                  <label for="exampleInputFile">Image</label>
                  <input type="file" id="uploadFile" name="image"><br>
                  <div id="imagePreview"></div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Name <span style="color: red">*</span></label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter category name" style="width: 30%" value="{{old('name')}}" name="name" required="">
                </div>

                <div class="form-group">
                <label>Food Category <span style="color: red">*</span></label><br>
                <select class="form-control select2" style="width: 30%;" required="" name="foodcategory">
                  @foreach($foodcategories as $foodcategory)
                  <option value="{{$foodcategory->id}}">{{$foodcategory->name}}</option>
                  @endforeach
                </select>
              </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Normal Price</label>
                  <div class="input-group">
                  <span class="input-group-addon">KES</span>
                  <input type="text" class="form-control" id="normalprice" placeholder="Enter normal size price" style="width: 27%" value="{{old('normalprice')}}" name="normalprice">
                  <script type="text/javascript">
                   $(document).ready(function() {
                   $('#normalprice').priceFormat();
                   });
                  </script>
                </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Small Size Price</label>
                  <div class="input-group">
                  <span class="input-group-addon">KES</span>
                  <input type="text" class="form-control" id="smallprice" placeholder="Enter small size price" style="width: 27%" value="{{old('smallprice')}}" name="smallprice">
                  <script type="text/javascript">
                   $(document).ready(function() {
                   $('#smallprice').priceFormat();
                   });
                  </script>
                </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Medium Size Price</label>
                  <div class="input-group">
                  <span class="input-group-addon">KES</span>
                  <input type="text" class="form-control" id="mediumprice" placeholder="Enter medium size price" style="width: 27%" value="{{old('mediumprice')}}" name="mediumprice">
                  <script type="text/javascript">
                   $(document).ready(function() {
                   $('#mediumprice').priceFormat();
                   });
                  </script>
                </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Large Size Price</label>
                  <div class="input-group">
                  <span class="input-group-addon">KES</span>
                  <input type="text" class="form-control" id="largeprice" placeholder="Enter large size price" style="width: 27%" value="{{old('largeprice')}}" name="largeprice">
                  <script type="text/javascript">
                   $(document).ready(function() {
                   $('#largeprice').priceFormat();
                   });
                  </script>
                </div>
                </div>
                
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          <!-- /.box -->
        </div>
        
          </div>
          <!-- /.box -->

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
  @stop
