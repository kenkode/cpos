
@extends('layouts.admin')
@section('content')

<style type="text/css">
  #imagePreview {
    width: 180px;
    height: 180px;
    background-position: center center;
    background-size: cover;
    background-image:url("{{asset('images/'.$user->photo) }}");
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
        User
        <small>Edit</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{URL::to('/users')}}"><i class="fa fa-users"></i> User</a></li>
        <li class="active">Edit</li>
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
              <h3 class="box-title">Edit </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ url('/users/update/'.$user->id) }}" enctype="multipart/form-data">
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
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter category name" style="width: 30%" value="{{$user->name}}" name="name" required="">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Email address <span style="color: red">*</span></label>
                  <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" style="width: 30%" value="{{$user->email}}" name="email" required="">
                </div>

                <div class="form-group">
                <label>Role <span style="color: red">*</span></label><br>
                <select class="form-control select2" style="width: 30%;" required="" name="role">
                  <option value="admin"<?= ($user->role=='admin')?'selected="selected"':''; ?>>admin</option>
                  <option value="waiter"<?= ($user->role=='waiter')?'selected="selected"':''; ?>>cashier</option> 
                </select>
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
