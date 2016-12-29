<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')  | PdnsAdmin</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="_token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{url('themes')}}/dist/img/favicon.ico" type="image/x-icon">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{url('themes')}}/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('themes')}}/dist/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{url('themes')}}/custom.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{url('themes')}}/dist/css/ionicons.min.css">
  <!-- jvectormap -->

  <link rel="stylesheet" href="{{url('themes')}}/plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('themes')}}/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{url('themes')}}/dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="{{url('themes')}}/plugins/jQueryUI/jquery-ui.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script language="javascript">
  var admin_url="{{url('')}}";
  </script>
  <script src="{{url('themes')}}/plugins/jQuery/jQuery-2.2.0.min.js"></script>
  <script src="{{url('themes')}}/plugins/jQueryUI/jquery-ui.min.js"></script>
  <script src="{{url('themes')}}/global.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="{{url('account')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>P</b>A</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>PDNS</b>ADMIN</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have no message</li>  
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have no notification</li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have no task</li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="@if(Auth::user()->avatar) {{url('/uploads')}}/{{Auth::user()->avatar}} @else {{url('/uploads/avatar')}}/default/avatar.jpg @endif" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="@if(Auth::user()->avatar) {{url('/uploads')}}/{{Auth::user()->avatar}} @else {{url('/uploads/avatar')}}/default/avatar.jpg @endif" class="img-circle" alt="User Image">
                <p>
                  {{ Auth::user()->name }} 
                  @if(Auth::user()->jobtitle) 
                  - {{ Auth::user()->jobtitle }}
                   @endif
                  <small>Member since {{ date('M. Y',time(Auth::user()->created_at)) }}</small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{url('/account/profile')}}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{url('/login/logout')}}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->  
        </ul>
      </div>
    </nav>
  </header>