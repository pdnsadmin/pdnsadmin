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
            <center><h4> You're all set!</h4></center>
            <div class="moddal">
              <div class="modal-dialog">
               <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Setup Completed</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
               
                  <div class="box-body">
                    <div>Please keep this information for your records:</div>
                    <div>
                      <strong> Admin info:</strong>
                    </div>
                    <div>    
                      <dl class="list-definition" id="admin-info">

                      <dt>Email:</dt>
                      <dd>{{ $setupinformation['email']}}</dd>

                      <dt>Password:</dt>
                      <dd>******</dd>

                      <dt>Your Panel Address:</dt>
                      <dd>
                          <a href="{{url('')}}" target="_blank" class="btn btn-primary">{{url('')}}</a>
                      </dd>       
                  </dl>
                    </div>

                  <div>
                      <strong class="box-title"> Database info:</strong>
                    </div>

                    <div>
                        
                        <dl id="db-info" class="list-definition">
                          <dt>Database Name:</dt>
                          <dd>{{ $setupinformation['database']}}</dd>

                          <dt>Username:</dt>
                          <dd>{{ $setupinformation['username']}}</dd>
                          <dt>Password:</dt>
                          <dd>******</dd>
                      </dl>
                    </div>
                    </div>
                    <!--End config powerdns-->
                  </div> 
                  <!-- /.box-body -->
                  <div class="box-footer">

                    <a  class="btn btn-primary" href="{{url('')}}">Go To Admin Panel </a>
                  </div>
               
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
<!-- AdminLTE App -->
<script src="{{url('themes')}}/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('themes')}}/dist/js/demo.js"></script>
</body>
</html>