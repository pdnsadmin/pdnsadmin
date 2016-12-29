@section('title')
{{ $users->name }}
@stop
@extends('pages.general.master')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      User Profile
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/account')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{url('/users')}}">Users</a></li>
      <li class="active">{{ $users->name }}</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!-- /.col -->
      <div class="col-md-9">
        <div class="nav-tabs-custom">

          <div class="tab-content">
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
            <div class="post form-horizontal">
              <div class="user-block">
                <img class="img-circle img-bordered-sm" src="@if($users->avatar) {{url('/uploads')}}/{{$users->avatar}} @else {{url('/uploads/avatar')}}/default/avatar.jpg @endif" alt="user image">
                <span class="username">
                  <a href="#">{{ $users->name }}</a>
                  <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                </span>
              </div>
              <!--start box-->
              <div class="box-body">
                <div class="box">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td>Action</td>
                        <td>  <a href="{{url('user/edit')}}/{{ $users->id }}"><i class="fa fa-fw fa-edit"></i></a> 
                          <a href="{{url('user/view')}}/{{ $users->id }}"><i class="fa fa-fw fa-remove"></i></a> </td>   
                        </tr>
                        <tr>
                          <td>Group</td>
                          <td> {{ $groups->name}}</td>   
                        </tr>
                        <tr>
                          <td>Name</td>
                          <td> {{ $users->name}}</td>   
                        </tr>
                        <tr>
                          <td>Job Title</td>
                          <td> {{ $users->jobtitle }}</td>   
                        </tr>
                        <tr>
                          <td>Phone</td>
                          <td> {{ $users->phone }}</td>   
                        </tr>
                        <tr>
                          <td>Location</td>
                          <td> {{ $users->location }}</td>   
                        </tr>
                        <tr>
                          <td>Root admin</td>
                          <td> {{ $is_root }}</td>   
                        </tr>
                        <tr>
                          <td>Signature</td>
                          <td> {{ $users->signature }}</td>   
                        </tr>
                        <tr>
                          <td>About me</td>
                          <td> {{ $users->biography }}</td>   
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!--end box-->
                <div class="clearfix"></div>
              </div>
            </div>
          </div>
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
<!-- /.content-wrapper -->
@stop