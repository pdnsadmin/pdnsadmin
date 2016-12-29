@section('title')
    Reset password
@stop
@extends('pages.general.login')
@section('content')
<div class="login-box">
  <div class="login-logo">
    <a href="{{url('')}}"><b>PDNS</b>ADMIN</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
  <p class="login-box-msg">Sign in to start your session</p>
    @if(count($errors)>0)
    <div class=" alert alert-danger">
       @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
       @endforeach
    </div>
     @endif
   



<form method="POST" action="/password/reset">
    {!! csrf_field() !!}
    <input type="hidden" name="token" value="{{ $token }}">

   

     <div class="form-group has-feedback">
        
        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Your Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>

    <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="New Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>

    <div class="form-group has-feedback">
        
        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>

    <div class="row">
        <div class="col-xs-7">
          &nbsp
        </div>
        <!-- /.col -->
        <div class="col-xs-5">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Reset password</button>
        </div>
        <!-- /.col -->
      </div>
</form>
</div>
  <!-- /.login-box-body -->
</div>
@stop