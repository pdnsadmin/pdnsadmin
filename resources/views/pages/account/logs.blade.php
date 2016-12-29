@section('title')
Your history
@stop
@extends('pages.general.master')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Logs  
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/account')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{url('/account')}}/logs">Logs</a></li>

    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Logs</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Domain</th>
                    <th>Action</th>
                    <th>Type</th>     
                    <th>Description</th>
                    <th>Created by</th>
                    <th>Time</th>
                  </tr>
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
                    <div>{{ substr($content['record']['content'],0,40) }} @if(strlen($content['record']['content'])>40).. @endif</div> 
                  </td>
                  <td>{{ $log->name }}</td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">{{ date('Y/m/d H:m',time($log->created_at)) }}</div>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Domain</th>
                  <th>Action</th>
                  <th>Type</th>  
                  <th>Description</th>
                  <th>Created by</th>
                  <th>Time</th>
                </tr>
              </tr>
            </tfoot>
          </table>
          <div class="pagination pull-right">{!! $logs->render() !!}</div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->
</div>
<script src="{{url('themes')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script>
  $(function () {

    $('#example1').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "order": [[6, "desc" ]],
      "info": false,
      "autoWidth": false
    });
    
  });
</script>
@stop