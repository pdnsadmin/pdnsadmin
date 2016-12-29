@section('title')
User
@stop
@extends('pages.general.master')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Users 
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/account')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{url('/users')}}">User</a></li>     
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Users</h3>
          </div>
          @if(Session::has('success'))
          <div class="alert alert-success">
            <div>{!! Session::get('success') !!}</div>
          </div>
          @endif 
          @if(Session::has('error'))
          <p class="alert alert-danger">{!! Session::get('error') !!}</p>
          @endif
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Group</th>     
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Action</th>
                  </tr>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $user)
                <tr>
                  <td><a href="{{url('user/view')}}/{{ $user->id }}">#{{ $user->id }}</a></td>
                  <td>{{ $user->name }} </td>
                  <td>{{ $user->email }}</td>
                  <td>{{$groups[$user->group_id]}}</td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">{{ date('Y/m/d H:m',time($user->created_at)) }}</div>
                  </td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">{{ date('Y/m/d H:m',time($user->updated_at)) }}</div>
                  </td>
                  <td>
                    <a href="{{url('user/edit')}}/{{ $user->id }}"><i class="fa fa-fw fa-edit"></i></a> 
                    <a href="javascript:void(0)" onclick="return confirmdelete('{{url('user/delete')}}/{{ $user->id }}');"><i class="fa fa-fw fa-remove"></i></a> 
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                 <th>ID</th>
                 <th>Name</th>
                 <th>Email</th>
                 <th>Group</th>
                 <th>Created</th>
                 <th>Updated</th>
                 <th>Action</th>
               </tr>
             </tr>
           </tfoot>
         </table>
         <div class="pagination pull-right">{!! $users->render() !!}</div>
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