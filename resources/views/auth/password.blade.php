@section('title')
    Forgot password
@stop
@extends('pages.general.login')
@section('content')
<div class="login-box">
  <div class="login-logo">
    <a href="{{url('')}}"><b>PDNS</b>ADMIN</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    
    <p class="login-box-msg">Reset your password</p>
     @if (count($errors) > 0)
        <div class=" alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif



    {!! Form::open(array('url' => 'password/email')) !!}
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
     
      <div class="row">
        <div class="col-xs-6">
          <div class="checkbox icheck">
            <label>
              &nbsp
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <button type="submit" class="btn btn-primary btn-block btn-flat pull-right">Send password</button>
        </div>
        <!-- /.col -->
      </div>
    {{ Form::close() }}

    <div class="social-auth-links text-center none">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div>
    <!-- /.social-auth-links -->

    <a href="{{url('login')}}">Singup</a><br>
    <a href="{{url('register')}}" class="text-center">Register a new membership</a>

  </div>
  <!-- /.login-box-body -->
</div>
@stop