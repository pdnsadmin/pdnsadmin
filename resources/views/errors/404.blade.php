<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Page not found  | PDNSADMIN</title>
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
  <link rel="stylesheet" href="{{url('themes')}}/plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('themes')}}/dist/css/AdminLTE.min.css">
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
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <div class="content-wrapper-">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        404 Error Page
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
       
        <li class="active">404 error</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
          <p>
            We could not find the page you were looking for.
            Meanwhile, you may <a href="{{url('')}}">return to dashboard</a> or try using the search form.
          </p>  
          <div><img src="{{url('themes')}}/dist/img/lock.png"></div>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->
  </div>
  <div class="clearfix"></div>
  <!-- /.content-wrapper -->
  <div class="wrap-footer">
  @include('pages.general.footer')
  </div>
</div>
<!-- ./wrapper -->
<script src="{{url('themes')}}/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
