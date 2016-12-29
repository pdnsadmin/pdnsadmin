@section('title')
Create an account
@stop
@extends('pages.general.login')
@section('content')
<div class="login-box">
  <div class="login-logo">
  <a href="{{url('')}}"><b>PDNS</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body"> 
    <p class="login-box-msg">Create and account</p>
    @if(count($errors)>0)
    <div class=" alert alert-danger">
      @foreach ($errors->all() as $error)
      <div>{{ $error }}</div>
      @endforeach
    </div>
    @endif
    @if(Session::has('error-message'))
    <p class="alert alert-danger">{{ Session::get('error-message') }}</p>
    @endif
    {!! Form::open(array('url' => 'register')) !!}
    <div class="form-group has-feedback">
      <input type="text" class="form-control" placeholder="Name" name="name">
      <span class="glyphicon glyphicon-user form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
      <input type="email" class="form-control" placeholder="Email" name="email">
      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
      <input type="password" class="form-control" placeholder="Password" name="password">
      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">
      <div class="col-xs-8">
        &nbsp
      </div>
      <!-- /.col -->
      <div class="col-xs-4">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
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
        <a href="{{url('password/email')}}">I forgot my password</a><br>
        <a href="{{url('login')}}" class="text-center">Login</a>
      </div>
      <!-- /.login-box-body -->
    </div>
    @stop