
@extends('layouts.admin')
@section('content')

<style type="text/css">
  #imagePreview {
    width: 180px;
    height: 180px;
    background-position: center center;
    background-image:url("{{asset('images/'.$setting->logo) }}");
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
        Settings
        <small>Organization Settings</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Settings</li>
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
              <h3 class="box-title">Settings</h3>
            </div>
             @if (Session::has('flash_message'))

            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            {{ Session::get('flash_message') }}
           </div>
          @endif

           @if (Session::has('delete_message'))

            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            {{ Session::get('delete_message') }}
           </div>
          @endif
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ url('/setting/update') }}" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputFile">Image</label>
                  <input type="file" id="uploadFile" name="image"><br>
                  <div id="imagePreview"></div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Name <span style="color: red">*</span></label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter name" style="width: 30%" value="{{$setting->name}}" name="name" required="">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Telephone <span style="color: red">*</span></label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter telephone number" style="width: 30%" value="{{$setting->phone}}" name="phone" required="">
                </div>

                <div class="form-group">
                  <label>Address</label>
                  <textarea class="form-control" style="width: 30%" name="address" rows="3" placeholder="Enter Address...">{{$setting->address}}</textarea>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">KRA Pin <span style="color: red">*</span></label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter kra pin" style="width: 30%" value="{{$setting->pin}}" name="pin" required="">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">VAT Number <span style="color: red">*</span></label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter VAT number" style="width: 30%" value="{{$setting->vat_no}}" name="vat_no" required="">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">VAT % <span style="color: red">*</span></label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter VAT %" style="width: 30%" value="{{$setting->vat}}" name="vat" required="">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">KRA/ETR Number <span style="color: red">*</span></label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="KRA/ETR Number" style="width: 30%" value="{{$setting->kra_etr}}" name="kra_etr" required="">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Serial Number <span style="color: red">*</span></label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter serial Number" style="width: 30%" value="{{$setting->serial_no}}" name="serial_no" required="">
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Receipt Footer</label>
                  <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Receipt footer" style="width: 30%" value="{{$setting->receipt_footer}}" name="receipt" required="">
                </div>
                
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a class="btn btn-success btn-sm" style="padding-top: 7px; padding-bottom: 7px; padding-left:20px; padding-right: 20px; " href="{{ URL::to('setting/individual/report/'.$setting->id)}}">Report</a>
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
