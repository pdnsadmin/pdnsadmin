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
            <center><h4>Step 3 - Powerdns configuration!</h4></center>
            <div class="moddal">
              <div class="modal-dialog">
               <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"> Web configuration</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{url('setup/finish')}}" method="post" class="setup-step-3">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="adminname">Admin Name</label>
                      <input class="form-control" id="adminname" placeholder="Enter your name" type="text" required="required" name="name">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email address</label>
                      <input class="form-control" id="exampleInputEmail1" placeholder="Enter email" type="email" required="required" name="email">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Password</label>
                      <input class="form-control" id="exampleInputPassword1" placeholder="Password" type="text" required="required" name="upassword" >
                    </div>
                  </div>
                  <!--Config powerdns-->
                  <div class="box-header with-border">
                   <h3 class="box-title"> Powerdns configuration</h3>
                 </div>
                 <div class="box-body">
                  <div class="form-group">
                    <label>Host master</label>
                    <input class="form-control" placeholder="Host master" type="text" name="hostmaster" value="" required="required">
                  </div>
                  <div class="clearfix"></div>
                  <div class="form-group ">
                    <label>Port</label>
                    <input class="form-control" placeholder="Port" type="text" name="api_port" value="8081" required="required">
                  </div>
                  <div class="clearfix"></div>
                  <div class="form-group ">
                    <label>Zone path</label>
                    <input class="form-control" placeholder="Zone path" type="text" name="zonepath" value="api/v1/servers/localhost/zones" required="required">
                  </div>
                  <div class="clearfix"></div>
                  <div class="form-group ">
                    <label>Protocol</label>
                    <input class="form-control" placeholder="Protocol" type="text" name="api_protocol" value="http" required="required">    
                  </div>
                  <div class="clearfix"></div>
                  <div class="form-group ">
                    <label>Api key</label>
                    <input class="form-control" placeholder="Api key" type="text" name="api_key" value="" required="required">
                  </div>
                  <div class="clearfix"></div>    
                  <div class="form-group">
                    <label>The value of the first NS-record</label>
                    <input class="form-control" placeholder="The value of the first NS-record" type="text" name="ns1" value="">
                  </div>
                  <div class="clearfix"></div>
                  <div class="form-group">
                    <label>The value of the second NS-record</label>
                    <input class="form-control" placeholder="The value of the second NS-record" type="text" name="ns2" value="">
                  </div>
                  <div class="clearfix"></div>
                  <div class="form-group">
                    <label>Hostmaster record</label>
                    <input class="form-control" placeholder="Hostmaster record" type="text" name="hostmaster_record_soa" value="" required="required">
                  </div>
                  <div class="clearfix"></div>
                </div>
                <!--End config powerdns-->
              </div> 
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Create </button>
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
<!-- FastClick -->
<script src="{{url('themes')}}/plugins/jQuery/jquery.validate.js" type="text/javascript"></script>
<!-- FastClick -->
<script language="javascript">
 $(function () {
  var is_safari = navigator.userAgent.indexOf("Safari") > -1;
  if (is_safari){
    $('.setup-step-3').validate();
  }
});
</script>
</body>
</html>