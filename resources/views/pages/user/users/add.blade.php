@section('title')
Add new user
@stop
@extends('pages.general.master')
@section('content')
<!-- Content Wrapper. Contains page content -->s
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      User Profile
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/account')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{url('/users')}}">Users</a></li>
      <li class="active">add new user</li>
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
            <div class="post">
              <div class="user-block">
                <img class="img-circle img-bordered-sm" src="{{url('/uploads/avatar')}}/default/avatar.jpg" alt="user image">
                <span class="username">
                  <a href="javascript:void(0)">New user</a>
                  <a href="javascript:void(0)" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                </span>
              </div>
              <!-- /.user-block -->    
              {!! Form::open(array('url'=>'user/store','method'=>'POST', 'files'=>true,'class'=>'form-horizontal','id'=>'create-new-user','name'=>'create-new-user')) !!}
              <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Group</label>
                <div class="col-sm-10">
                  <select name="group_id" id="group_id">
                    <option value="0">-- Select group</option>
                    @foreach ($groups as $group)
                    <option value="{{ $group->id }}"> {{ $group->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Name</label>

                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputName" placeholder="Name" value="" name="name" required = "true">
                </div>
              </div>
              <div class="form-group">
                <label for="inputeEmail" class="col-sm-2 control-label">Email</label>

                <div class="col-sm-10">
                  <input type="email" class="form-control" id="inputeEmail" placeholder="Email" value="" name="email" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputJobtitle" class="col-sm-2 control-label">Job Title</label>

                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputJobtitle" placeholder="Job title" name="jobtitle" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPhone" class="col-sm-2 control-label">Phone</label>

                <div class="col-sm-10">
                  <input type="phone" class="form-control" id="inputPhone" placeholder="Phone number" name="phone" value="" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                </div>
              </div>
              <div class="form-group">
                <label for="inputLocation" class="col-sm-2 control-label">Location</label>

                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputLocation" placeholder="Location" name="location" value="">
                </div>
              </div>

              <div class="form-group">
                <label for="inputPassword" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                  <label class="control-label none" for="inputError"><i class="fa fa-times-circle-o"></i> 
                  </label>
                  <input type="password" class="form-control password" id="inputPassword" placeholder="Password" name="password" required="required">          
                </div>
              </div>
              <div class="form-group">
                <label for="inputRootAdmin" class="col-sm-2 control-label">Root admin</label>
                <div class="col-sm-10">
                  <select name="isroot" id="inputRootAdmin">
                    <option value="0" id="input_select_is_root_0">No</option>
                    <option value="1" id="input_select_is_root_1">Yes</option>
                  </select>
                  Yes: that mean you set full access to this account. No: this account depend on permission below.      
                </div>
              </div>
              <div class="form-group">
                <label for="inputSignature" class="col-sm-2 control-label">Signature</label>
                <div class="col-sm-10">
                  <textarea class="form-control input-sm" placeholder="Signature" name="signature" id="inputSignature" ></textarea>
                </div>
              </div>
              <div class="form-group">
               <label for="inputAboutMe" class="col-sm-2 control-label">About me</label>
               <div class="col-sm-10">
                 
                <textarea class="form-control input-sm" placeholder="About me" name="biography" id="inputAboutMe"></textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <label for="inputAvatar" class="col-sm-2 control-label">Avatar</label>
                <div class="col-sm-10">
                  <input placeholder="Avatar" type="file" name="image" id="inputAvatar">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-danger" value="Create">
              </div>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->
</div>
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.js"></script>
<script language="javascript">
 $(function () {
  var is_safari = navigator.userAgent.indexOf("Safari") > -1;
  $("[data-mask]").inputmask();
  if (is_safari){
    $('#create-new-user').validate();
  }
});
</script>
<!-- /.content-wrapper -->
@stop