@section('title')
Authentication
@stop
@extends('pages.general.master')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Authentication
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/account')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Authentication</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">   
      <!-- /.col -->
      <div class="col-md-12">
        <div class="error-page">
          <h2 class="headline text-yellow"> API </h2>
          <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Opps! The error is occurred. </h3>
            <p>
              <div>We could not find the page you were looking for.</div>
              <div>Please check <a href="{{url('/settings')}}">API Authentication</a> again.</div>
              <div>- API Key</div>
              <div>- API Host</div>
              <div>- API Zone path</div>
              <div>- API port</div>
            </p>    
          </div>
        </div>
      </div>
      <!-- /.col -->
    </div>
  </section>
  <!-- /.content -->
</div>
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.js"></script>
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- /.content-wrapper -->
@stop