@section('title')
My profile
@stop
@extends('pages.general.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      User Profile
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/account')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">User profile</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="@if(Auth::user()->avatar) {{url('/uploads')}}/{{Auth::user()->avatar}} @else {{url('themes')}}/images/avatar/default/avatar.jpg @endif" alt="User profile picture">
            <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>

            <p class="text-muted text-center">{{ Auth::user()->jobtitle }}</p>
          </div>
        </div>
        <!-- About Me Box -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">About Me</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <p class="text-muted">
              {{ Auth::user()->biography }}
            </p>
            <hr>
            <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
            <p class="text-muted"> {{ Auth::user()->location }}</p>
            <hr>
            <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>
            <p>{{ Auth::user()->overview }}</p>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active li-activity"><a href="#activity" data-toggle="tab">About me</a></li>
            <li class="li-settings"><a href="#settings" data-toggle="tab">Settings</a></li>
            <li class="li-changepass"><a href="#changepass" data-toggle="tab">Change password</a></li>
          </ul>
          <div class="tab-content">
           @if(Session::has('success'))
           <div class="alert alert-success">
            <div>{!! Session::get('success') !!}</div>
          </div>
          @endif
          @if(Session::has('error'))
          <p class="alert alert-danger">{!! Session::get('error') !!}</p>
          @endif
          <div class="active tab-pane" id="activity">
            <!-- Post -->
            <div class="post">
              <div class="user-block">
                <img class="img-circle img-bordered-sm" src="@if(Auth::user()->avatar) {{url('/uploads')}}/{{Auth::user()->avatar}} @else {{url('themes')}}/images/avatar/default/avatar.jpg @endif" alt="user image">
                <span class="username">
                  <a href="#">{{ Auth::user()->name }}</a>
                  <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                </span>
              </div>
              <!-- /.user-block -->
              <p>
                {{ Auth::user()->biography }}
              </p>
              {!! Form::open(array('url'=>'account/avatar','method'=>'POST', 'files'=>true,'class'=>'form-horizontal')) !!}
              <div class="form-group margin-bottom-none">
                <div class="col-sm-9">
                  <input class="form-control input-sm" placeholder="Avatar" type="file" name="image">
                </div>
                <div class="col-sm-3">
                  <button type="submit" class="btn btn-danger pull-right btn-block btn-sm">Save</button>
                </div>
              </div>
              {!! Form::close() !!}
              <br>
              {!! Form::open(array('url'=>'account/biography','method'=>'POST','class'=>'form-horizontal')) !!}
              <div class="form-group margin-bottom-none">
                <div class="col-sm-9">
                  <textarea class="form-control input-sm" placeholder="About me" name="biography">{{ Auth::user()->biography }}</textarea>
                </div>
                <div class="col-sm-3">
                  <button type="submit" class="btn btn-danger pull-right btn-block btn-sm">Save</button>
                </div>
              </div>
              {!! Form::close() !!}
              <br>
              {!! Form::open(array('url'=>'account/signature','method'=>'POST','class'=>'form-horizontal')) !!}
              <div class="form-group margin-bottom-none">
                <div class="col-sm-9">
                  <textarea class="form-control input-sm required" placeholder="Signature" name="signature" required="required">{{ Auth::user()->signature }}</textarea>
                </div>
                <div class="col-sm-3">
                  <button type="submit" class="btn btn-danger pull-right btn-block btn-sm">Save</button>
                </div>
              </div>
              {!! Form::close() !!}
            </div>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="settings">
           {!! Form::open(array('url'=>'account/setting','method'=>'POST','class'=>'form-horizontal')) !!}
           <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="inputName" placeholder="Name" value="{{ Auth::user()->name }}" name="name">
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail" class="col-sm-2 control-label">Job Title</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="inputEmail" placeholder="Job title" name="jobtitle" value="{{ Auth::user()->jobtitle }}">
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail" class="col-sm-2 control-label">Phone</label>
            <div class="col-sm-10">
              <input type="phone" class="form-control" id="inputEmail" placeholder="Phone number" name="phone" value="{{ Auth::user()->phone }}" data-inputmask='"mask": "(999) 999-9999"' data-mask>
            </div>
          </div>
          <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Location</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="inputName" placeholder="Location" name="location" value="{{ Auth::user()->location }}">
            </div>
          </div>                 
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-danger">Submit</button>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
        <div class="tab-pane" id="changepass">
          {!! Form::open(array('url'=>'account/changepass','method'=>'POST','class'=>'form-horizontal')) !!}
          <div class="form-group">
            <div class="col-lg-6 col-md-6 col-sm-6 col-sx-12">
              <label class="control-label none" for="inputError"><i class="fa fa-times-circle-o"></i> <span class="label-password">Please make sure your passwords match</span>
              </label>
              <input type="password" class="form-control password" id="inputEmail" placeholder="New Password" name="password">          
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-sx-12"> 
             <label class="control-label none" for="inputError"><i class="fa fa-times-circle-o"></i> <span class="label-repassword">Please make sure your passwords match</span></label>  
             <input type="password" class="form-control repassword" id="inputRepassword" placeholder="Re-password" name="repassword" >  
           </div>
         </div>
         <div class="form-group">
          <div class="col-lg-6 col-md-6 col-sm-6 col-sx-12">
           <label class="control-label none" for="inputError"><i class="fa fa-times-circle-o"></i> <span class="label-oldpassword">Enter your current password</span></label> 
           <input type="password" class="form-control oldpassword" id="inputEmail" placeholder="Current password" name="oldpassword">
         </div>
         <div class="col-lg-6 col-md-6 col-sm-6 col-sx-12">
          <button type="submit" class="btn btn-danger change-password" onclick="javascript:void(0);">Change password</button>
        </div>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
  <!-- /.tab-pane -->
</div>
<!-- /.tab-content -->
</div>
<!-- /.nav-tabs-custom -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->
</div>
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.js"></script>
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script language="javascript">
 $(function () {
  $("[data-mask]").inputmask();
  $('.change-password').click(function(){
    if($('input.password').val()=='' || ($('input.password').val()!=$('input.repassword').val() ))
    {
      $('input.password').parent().addClass('has-error');
      $('.label-password').html('Please make sure your passwords match');  
      $('input.repassword').parent().addClass('has-error');
      return false;
    }
    if($('input.password').val().length<6)
    {
      $('input.password').parent().addClass('has-error');
      $('.label-password').html('Please enter at least 6 characters.');
      return false;     
    }
    $('input.password').parent().removeClass('has-error');
    $('input.repassword').parent().removeClass('has-error');
    if($('input.oldpassword').val()=='')
    {
      $('input.oldpassword').parent().addClass('has-error');
      $('.label-oldpassword').html('Enter your current password.');
      return false;
    }
    if($('input.oldpassword').val().length<6)
    {
      $('input.oldpassword').parent().addClass('has-error');
      $('.label-oldpassword').html('Please enter at least 6 characters.'); 
      return false;
    }
    return true;
  })
});
 var url_check_anchor=window.location.href;
 var url_hash = url_check_anchor.substring(url_check_anchor.indexOf("#")+1);
 if(url_hash=='changepass'||url_hash=='settings')
 {
  $('.nav-tabs li').removeClass('active');
  $('.tab-pane').removeClass('active');
  $('.nav-tabs li.li-'+url_hash).addClass('active');
  $('#'+url_hash).addClass('active');
}
else
{
  $('.nav-tabs li').removeClass('active');
  $('.nav-tabs li.li-activity').addClass('active');
}
</script>
<!-- /.content-wrapper -->
@stop