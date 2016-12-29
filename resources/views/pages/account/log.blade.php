@section('title')
History retail
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
      <li>History detail</li>    
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
                    <th>content</th>
                    <th>Created by</th>
                    <th>Time</th>
                  </tr>
                </tr>
              </thead>
              <tbody>   
                <tr>
                  <td>#{{ $logs->id }}</td>
                  <td>{{ $logs->domain }} </td>
                  <td><span class="label {{ $label[$logs->action] }}">{{ $logs->action }}</span></td>
                  <td>
                   @foreach ($content as $k=>$v)
                   <div>{{ $k }}: {{ $v }}</div>
                   @endforeach
                 </td>
                 <td>{{ $logs->name }}</td>
                 <td>
                  <div class="sparkbar" data-color="#00a65a" data-height="20">{{ $logs->created_at }}</div>
                </td>
              </tr>     
            </tbody>      
          </table>  
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
      "info": false,
      "autoWidth": false
    });  
  });
</script>
@stop