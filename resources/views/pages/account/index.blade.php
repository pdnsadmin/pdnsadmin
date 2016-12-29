@section('title')
Dashboard
@stop
@extends('pages.general.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      PowerDNS
      <small>Version 1.0.1</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Info boxes -->
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="fa fa-external-link"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Domains</span>
            <span class="info-box-number">{{ $domain_count }}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-red"><i class="ion ion-ios-gear-outline"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Profile</span>
            <span class="info-box-number">{{ $percent }}<small>%</small></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fa fa-ticket"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Tikets</span>
            <span class="info-box-number">0</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow"><i class="fa fa-bell-o"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Notifications</span>
            <span class="info-box-number">0</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <div class="col-md-8">
        <!-- /.row -->
        <!-- TABLE: LATEST ORDERS -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">System Logs</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Domain</th>
                    <th>Action</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Time</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($logs as $log)
                  <tr>
                    <td><a href="{{url('account/log/view')}}/{{ $log->id }}">#{{ $log->id }}</a></td>
                    <td>{{ $log->domain }} </td>
                    <td><span class="label {{ $label[$log->action] }}">{{ $log->action }}</span></td>
                    <?php $content = unserialize($log->content);?> 
                    <td>{{ $content['record']['type'] }}</td>
                    <td>
                      <div>{{ substr($content['record']['content'],0,20) }} @if(strlen($content['record']['content'])>20).. @endif</div>
                    </td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20">{{ date('Y/m/d H:m',time($log->created_at)) }}</div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer clearfix">
            <a href="{{url('account/logs')}}" class="btn btn-sm btn-default btn-flat pull-right">View All Logs</a>
          </div>
          <!-- /.box-footer -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
      <div class="col-md-4">
        <!--  Recently Added Domains -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Recently Added Domains</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <ul class="products-list product-list-in-box">
              @foreach ($domains as $domain)
              <li class="item">
                <div class="product-img">
                  <div class="domain-name">{{ substr($domain->name,0,1) }}</div>
                </div>
                <div class="product-info">
                  <a href="{{url('account/domain/edit')}}/{{ $domain->id }}" class="product-title">{{ $domain->name }}
                    <span class="label label-warning pull-right">{{ $domain->master }}</span></a>
                    <span class="product-description">
                      {{$domain->created_at}}
                    </span>
                  </div>
                </li>
                @endforeach
                <!-- /.item -->
                <!-- /.item -->
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
              <a href="{{url('account/domains')}}" class="uppercase">View All Domains</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @stop