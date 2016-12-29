<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PdnsAdmin Installation Wizard</title>
  <!-- Tell the Ip to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{url('themes')}}/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('themes')}}/dist/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{url('themes')}}/dist/css/ionicons.min.css">
  <!-- jvectormap -->
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('themes')}}/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{url('themes')}}/dist/css/skins/_all-skins.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue layout-top-nav">
  <div class="wrapper">
    <header class="main-header">
      <nav class="navbar navbar-static-top">
        <div class="container">
          <div class="navbar-header">
            <center style="color:#FFF"><h2>Installation Wizard</h2></center>          
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->     
          <!-- /.navbar-collapse -->
          <!-- Navbar Right Menu -->
          <!-- /.navbar-custom-menu -->
        </div>
        <!-- /.container-fluid -->
      </nav>
    </header>
    <!-- Full Width Column -->
    <div class="content-wrapper">
      <div class="container">
        <!-- Content Header (Page header) -->
        <section class="content-header">     
        </section>
        <!-- Main content -->
        <section class="content">

          <div class="callout" style="margin: 0 auto;">
            <center><h4>Step 2 - Database configuration!</h4></center>
            <div class="moddal">
              <div class="modal-dialog">
               <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Database configuration</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{url('setup/step3')}}" method="post" class="setup-step-2">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="box-body">
                    @if(Session::has('error'))
                    <p class="alert alert-danger">{!! Session::get('error') !!}</p>
                    @endif
                    <div class="form-group">
                      <label for="database-server-host">Database server Host</label>
                      <input class="form-control" id="database-server-host" placeholder="localhost" type="text" name="localhost" required value="localhost">
                    </div>
                    <div class="form-group">
                      <label for="database-server-host">Database server Username</label>
                      <input class="form-control" id="database-server-name" placeholder="Database server Name" type="text" name="databaseusername" required="required">
                    </div>
                    <div class="form-group">
                      <label for="database-server-Password">Database server Password</label>
                      <input class="form-control" id="database-server-Password" placeholder="Database server Password" type="text" name="serverpassword">
                    </div>
                    <div class="form-group">
                      <label for="database-server-host">Database Name</label>
                      <input class="form-control" id="database-name" placeholder="Database  Name" type="text" name="databasename" required="required">
                    </div>
                  </div> 
                  <!-- /.box-body -->

                  <div class="box-footer">

                    <button type="submit" class="btn btn-primary">Next </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="container">
      <strong>Copyright &copy; <?php echo date('Y',time())?> <a href="http://pdnsadmin.com">www.pdnsadmin.com</a>.</strong> All rights
      reserved.
    </div>
    <!-- /.container -->
  </footer>
</div>
<script src="{{url('themes')}}/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{url('themes')}}/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="{{url('themes')}}/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="{{url('themes')}}/plugins/jQuery/jquery.validate.js" type="text/javascript"></script>
<!-- FastClick -->
<script language="javascript">
 $(function () {
  var is_safari = navigator.userAgent.indexOf("Safari") > -1;
  if (is_safari){
    $('.setup-step-2').validate();
  }
});
</script>
</body>
</html>