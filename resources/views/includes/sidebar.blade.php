<?php
$categories = App\Foodcategory::all();
?>

<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
                @if(Auth::user()->photo != null || Auth::user()->photo != '')
                <img src="{{asset('images/'.Auth::user()->photo)}}" class="img-circle" style="width: 50px !important; height: 50px !important" alt="User Image">
                @else
                <img src="{{asset('img/user.png')}}" class="user-image" alt="User Image">
                @endif
        </div>
        <div class="pull-left info">
          <p>{{Auth::user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        
        <li>
          <a href="{{URL::to('/')}}">
            <i class="fa fa-home"></i> <span>Dashboard</span>
          
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-cutlery"></i>
            <span>Food</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{URL::to('/category')}}"><i class="fa fa-circle-o"></i> Categories</a></li>
            <li><a href="{{URL::to('/food')}}"><i class="fa fa-circle-o"></i> Food</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-desktop"></i>
            <span>POS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
        @foreach($categories as $category)
        <li>
          <a href="{{URL::to('/admin/view/food/'.$category->id)}}">
            <i class="fa fa-circle-o"></i> <span>{{$category->name}}</span>

          </a>
        </li>
        @endforeach
        </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Orders</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{URL::to('/admin/orders')}}"><i class="fa fa-circle-o"></i> Orders</a></li>
            <li><a href="{{URL::to('/admin/orders/payments')}}"><i class="fa fa-circle-o"></i> Payments</a></li>
          </ul>
        </li>

        <li>
          <a href="{{URL::to('/admin/summary/')}}">
            <i class="fa fa-file"></i> <span>Summary</span>
          
          </a>
        </li>

        <li>
          <a href="{{URL::to('/users')}}">
            <i class="fa fa-users"></i> <span>Users</span>

          </a>
        </li>
        <li>
          <a href="{{URL::to('/setting')}}">
            <i class="fa fa-cogs"></i> <span>Settings</span>
          
          </a>
        </li>
        <li>
          <a href="{{URL::to('/admin/profile')}}">
            <i class="fa fa-user"></i> <span>Profile</span>
          
          </a>
        </li>
        <li>
          <a href="{{ url('/logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out"></i> <span>Logout</span>

            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
          
          </a>
        </li>
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>