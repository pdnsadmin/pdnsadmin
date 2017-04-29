@section('title')
Setting
@stop
@extends('pages.general.master')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Configuration PowerDns
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/account')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Configuration</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">   
      <!-- /.col -->
      <div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">    
            <li class="active li-defaultttl"><a href="#defaultttl" data-toggle="tab">Default TTL</a></li>
          </ul>
          <div class="clearfix"></div><br>
          {!! Form::open(array('url'=>'account/configttl','method'=>'POST','class'=>'form-horizontal-setting')) !!}
          <div class="tab-content">
           @if(Session::has('success'))
           <div class="alert alert-success">
            <div>{!! Session::get('success') !!}</div>
          </div>
          @endif
          @if(Session::has('error'))
          <p class="alert alert-danger">{!! Session::get('error') !!}</p>
          @endif 
          <div class="tab-pane active" id="defaultttl">
            <div class="post">
              <div class="user-block">
                <div class="form-group ">
                  <div class="col-sm-8">
                    <label class="col-sm-2">Default TTL</label>
                    <div class="col-sm-10">     
                      <?php $ttl_user=Auth::user()->ttl;?>
                      <select tabindex="-1" class="form-control select2 ttl"  name="ttl" style="width: 100%;"><option value="120"  @if($ttl_user==120) selected="selected"  @endif >2 minutes</option><option value="300">5 minutes</option><option value="600"  @if($ttl_user==600) selected="selected"  @endif >10 minutes</option><option value="900"  @if($ttl_user==900) selected="selected"  @endif >15 minutes</option><option value="1800"  @if($ttl_user==1800) selected="selected"  @endif >30 minutes</option><option value="3600"  @if($ttl_user==3600) selected="selected"  @endif >1 hour(Automatic TTL)</option><option value="7200"  @if($ttl_user==7200) selected="selected"  @endif >2 hours</option><option value="18000"  @if($ttl_user==18000) selected="selected"  @endif >5 hours</option><option value="43200"  @if($ttl_user==43200) selected="selected"  @endif >12 hours</option><option value="86400"  @if($ttl_user==86400) selected="selected"  @endif  >1 day</option></select>
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>       
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="form-group clearfix">
            <div class="col-sm-1">
              <button type="submit" class="btn btn-danger pull-right btn-block btn-sm">Save</button>
            </div>
          </div>
          <div class="clearfix"></div>       
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</section>
<!-- /.content -->
</div>
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.js"></script>
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.extensions.js"></script>
@stop