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
          <?php
          $laravel = app();
          $laravel_verion=$laravel::VERSION;
          ?>
          <div class="callout">
            <div class="moddal">
              <div class="modal-dialog">
               <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Step 1 - System Requirements</h3>
                </div>
                <div class="box">
                  <table class="table table-bordered">
                    <tr><td colspan="2">Your system</td></tr>
                    <tr>
                      <td>Public/uploads<i class="btn-danger">(Must be writeable)</i></td>

                      <?php
                      $ERROR_1=0;
                      if(is_writable($_SERVER['DOCUMENT_ROOT'].'/uploads')):
                      $ERROR_1=1;
                      ?><td>Writeable</td>
                    <?php else:?>
                      <td >Non-Writeable</td>	
                    <?php endif;?>	

                  </tr>
                  <tr>
                    <td>Php Version</td>
                    <td  ><?php echo phpversion();?></td>
                  </tr>
                  <tr><td colspan="2">Server Requirements</td></tr>
                  <tr>
                    <td>Requirements</td>
                    <td >

                      <div>PHP >=<?php if($laravel_verion<5.3):?>5.5.9<?php else:?>5.6.4<?php endif;?></div>
                      <div>OpenSSL PHP Extension</div>
                      <div>PDO PHP Extension</div>
                      <div>Mbstring PHP Extension</div>
                      <div>Tokenizer PHP Extension</div>
                      <div>XML PHP Extension</div>

                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td ></td>
                  </tr>
                </table>
              </div>

            </div>
            <div class="clearfix"></div>
            <?php if($ERROR_1==1):?>
              <div class="input-group input-group-sm"><a type="button" href="{{url('/setup/step2')}}" class="btn btn-info pull-right" title="Step 2"><strong>NEXT</strong></a></div>
            <?php else:?>
             <div class="input-group input-group-sm"><button type="button" href="javascript:void(0);" onclick="javascript:alert('Folder uploads must be writeable');" class="btn btn-block btn-default" title="Step 2"><strong>NEXT</strong></button></div>
           <?php endif;?>	
           <div class="clearfix"></div>

         </div>
       </div>
     </div>   
     <!-- /.box -->
   </section>
   <!-- /.content -->
 </div>
 <!-- /.container -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
  <div class="container">
    <div class="pull-right hidden-xs">

    </div>
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
<script src="{{url('themes')}}/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{url('themes')}}/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('themes')}}/dist/js/demo.js"></script>
</body>
</html>