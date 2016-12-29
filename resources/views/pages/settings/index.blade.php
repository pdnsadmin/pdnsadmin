@section('title')
Setting
@stop
@extends('pages.general.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<!-- Content Wrapper. Contains page content -->
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
            <li class="active li-activity"><a href="#activity" data-toggle="tab">pdnsAPI</a></li>
            <li class="li-optional"><a href="#optional" data-toggle="tab">NameServer</a></li>
            <li class="li-defaultttl"><a href="#defaultttl" data-toggle="tab">Default TTL</a></li>
          </ul>
          <div class="clearfix"></div><br>
          {!! Form::open(array('url'=>'settings','method'=>'POST','class'=>'form-horizontal-setting')) !!}
          <div class="tab-content">
            <div class="alert alert-danger">Do not share your credential information with anyone</div>
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
                  <!-- /.user-block -->
                  <?php $i=1;?>                              
                  @foreach ($settings as $k=>$v)
                  @if($i<=6)
                  <div class="form-group ">
                    <div class="col-sm-6">
                      <label>{{ $v['name'] }}</label>
                      <input class="form-control input-sm" placeholder="{{ $v['name'] }}" type="text" name="name[{{ $k }}]" value="{{ $v['value'] }}">
                    </div>
                    <?php $i++;?>
                  </div>
                  <div class="clearfix"></div>
                  @endif
                  @endforeach                                  
                  <br>
                </div>
                <!-- Post -->             
              </div>
              <!-- /.tab-pane -->
            </div>
            <?php $i=1;?>
            <div class="tab-pane" id="optional">
              <div class="post">
                <div class="user-block">
                  @foreach ($settings as $k=>$v)
                  @if($i>6)
                  <div class="form-group ">
                    <div class="col-sm-6">
                      <label>{{ $v['name'] }}</label>
                      <input class="form-control input-sm" placeholder="{{ $v['name'] }}" type="text" name="name[{{ $k }}]" value="{{ $v['value'] }}">
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  @endif
                  <?php $i++;?>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="tab-pane" id="defaultttl">
              <div class="post">
                <div class="user-block">
                  <div class="form-group ">
                    <div class="col-sm-8">
                      <label class="col-sm-2">Default TTL</label>
                      <div class="col-sm-10">     
                        <?php $ttl_user=Auth::user()->ttl;?>
                        <select tabindex="-1" class="form-control select2 ttl"  name="ttl" style="width: 100%;"><option value="120"  @if($ttl_user==120) class="automaticTTL" selected="selected"  @endif >2 minutes</option><option value="300" @if($ttl_user==300) class="automaticTTL" selected="selected"  @endif >5 minutes</option><option value="600"  @if($ttl_user==600) class="automaticTTL" selected="selected"  @endif >10 minutes</option><option value="900"  @if($ttl_user==900) class="automaticTTL" selected="selected"  @endif >15 minutes</option><option value="1800"  @if($ttl_user==1800) class="automaticTTL" selected="selected"  @endif >30 minutes</option><option value="3600"  @if($ttl_user==3600) class="automaticTTL" selected="selected"  @endif >1 hour</option><option value="7200"  @if($ttl_user==7200) class="automaticTTL" selected="selected"  @endif >2 hours</option><option value="18000"  @if($ttl_user==18000) class="automaticTTL" selected="selected"  @endif >5 hours</option><option value="43200"  @if($ttl_user==43200) class="automaticTTL" selected="selected"  @endif >12 hours</option><option value="86400"  @if($ttl_user==86400) class="automaticTTL" selected="selected"  @endif  >1 day</option></select>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div> 
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
              <div class="col-sm-1">
                <button type="submit" class="btn btn-danger pull-right btn-block btn-sm">Save</button>
              </div>
            </div>
            <div class="clearfix"></div>       
            <!-- /.tab-pane -->
          </div>
          {!! Form::close() !!} 
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
<!-- /.content-wrapper -->
@stop