<?php 
$setting = App\Setting::find(1);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  @if($setting->name != null || $setting->name != '')
  <title>{{$setting->name}}</title>
  @else
  <title>RPOS</title>
  @endif
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">

  @if($setting->logo != null || $setting->logo != '')
  <link rel="shortcut icon" href="{{asset('images/'.$setting->logo)}}">
  @else
  <link rel="shortcut icon" href="{{asset('img/covered-food-tray-on-a-hand-of-hotel-room-service (1).png')}}">
  @endif
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset('css/skins/_all-skins.min.css')}}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{asset('morris.js/morris.css')}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{asset('jvectormap/jquery-jvectormap.css')}}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{asset('bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('bootstrap-daterangepicker/daterangepicker.css')}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{asset('bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
  <link href="{{asset('css/smart_cart.min.css')}}" rel="stylesheet" type="text/css" />

  <link rel="stylesheet" href="{{asset('datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/skins/_all-skins.min.css')}}">
  <link rel="stylesheet" href="{{asset('select2/dist/css/select2.min.css')}}">

  <script src="{{asset('jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('js/price_format.js')}}"></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{URL::to('/')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      @if($setting->logo != null || $setting->logo != '')
      <img src="{{asset('images/'.$setting->logo)}}" class="user-image" width="30" height="30" alt="Logo" style="float: left; margin-top: 10px; margin-right: 
      10px">
      @else
      <img src="{{asset('img/covered-food-tray-on-a-hand-of-hotel-room-service.png')}}" class="user-image" width="30" height="30" alt="Logo" style="float: left; margin-top: 10px; margin-right: 
      10px">
      @endif
      <!-- <span class="logo-mini"><b>R</b>PS</span> -->
      <!-- logo for regular state and mobile devices -->
      @if($setting->name != null || $setting->name != '')
      <span style="float: left" class="logo-lg">{{$setting->name}}</span>
      @else
      <span style="float: left" class="logo-lg"><b>R</b>POS</span>
      @endif
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
         
          <!-- Notifications: style can be found in dropdown.less -->
          
          <!-- Tasks: style can be found in dropdown.less -->
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu" style="margin-top: -5px">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              @if(Auth::user()->photo != null || Auth::user()->photo != '')
                <img src="{{asset('images/'.Auth::user()->photo)}}" class="img-circle" width="25" height="25" alt="User Image">
                @else
                <img src="{{asset('img/user.png')}}" class="user-image" width="50" height="50" alt="User Image">
                @endif
              
              <span class="hidden-xs">{{Auth::user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                @if(Auth::user()->photo != null || Auth::user()->photo != '')
                <img src="{{asset('images/'.Auth::user()->photo)}}" class="img-circle" alt="User Image">
                @else
                <img src="{{asset('img/user.png')}}" class="img-circle" alt="User Image">
                @endif
                <p>
                  {{Auth::user()->name}} - 
                  @if(Auth::user()->role == 'admin')
                  Admin
                  @elseif(Auth::user()->role == 'waiter')
                  Waiter
                  @elseif(Auth::user()->role == 'kitchen')
                  Kitchen
                  @elseif(Auth::user()->role == 'cashier')
                  Cashier
                  @endif
                  <small>System User</small>
                </p>
              </li>
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{URL::to('profile')}}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">

                  <a href="{{ url('/logout') }}" class="btn btn-default btn-flat"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Sign out
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>

                </div>
              </li>
            </ul>
          </li>
         
        </ul>
      </div>
    </nav>
  </header>
  


  