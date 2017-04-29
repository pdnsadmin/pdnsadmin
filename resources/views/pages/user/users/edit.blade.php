@section('title')
Edit: {{ $users->name }}
@stop
@extends('pages.general.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<script language="javascript">
  <!--
  var on_mouse = 0;
  
  function checkbox( id )
  {
    if ( on_mouse == 0 )
    {
      if ( document.getElementById( id ).checked == true )
      {
        document.getElementById( id ).checked = "";
      }
      else
      {
        document.getElementById( id ).checked = "checked";
      }
    }
  }
  var data_backup = ""; 
  function change_group()
  {
    if ( '{{ $users->group_id }}' != document.getElementById("group_id").options[document.getElementById("group_id").selectedIndex].value )
    {
      if ( confirm("Do you want to SET NEW GROUP'S PERMISSION to this User ?") == true )
      {
        document.getElementById("update").checked = "checked";
        data_backup = document.getElementById("update_permission").innerHTML;
        document.getElementById("update_permission").innerHTML = "<i><font color='red'>* The user's permission will be edited when you clink on button "+'"Save"'+"</font></i>";
      }
      else
      {
          //document.getElementById("update").checked = "";
          //document.getElementById("update_permission").innerHTML = data_backup;
          //data_backup = "";
        }
      }
      else
      {
        document.getElementById("update").checked = "";
        document.getElementById("update_permission").innerHTML = data_backup;
        data_backup = "";
      }
    }
    //-->
  </script>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit User
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
              <div class="post">
                <div class="user-block">
                  <img class="img-circle img-bordered-sm" src="@if($users->avatar) {{url('/uploads')}}/{{$users->avatar}} @else {{url('/uploads/avatar')}}/default/avatar.jpg @endif" alt="user image">
                  <span class="username">
                    <a href="#">{{ $users->name }}</a>
                    <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                  </span>
                </div>
                <!-- /.user-block -->
                {!! Form::open(array('url'=>'user/update','method'=>'POST', 'files'=>true,'class'=>'form-horizontal')) !!}
                <input type="hidden" name="id" value="{{ $users->id }}">
                <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Group</label>
                  <div class="col-sm-10">
                    <select name="group_id" id="group_id" onchange="change_group();">
                      <option value="0" id="input_select_0">-- Select group</option>
                      @foreach ($groups as $group)
                      <option value="{{ $group->id }}" id="input_select_{{ $group->id }}"> {{ $group->name }}</option>
                      @endforeach
                    </select>
                    <font style="display: none;"><input type="checkbox" name="update" id="update" value="1" /></font>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputName" placeholder="Name" value="{{ $users->name }}" name="name">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail" class="col-sm-2 control-label">Job Title</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEmail" placeholder="Job title" name="jobtitle" value="{{ $users->jobtitle }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail" class="col-sm-2 control-label">Phone</label>
                  <div class="col-sm-10">
                    <input type="phone" class="form-control" id="inputEmail" placeholder="Phone number" name="phone" value="{{ $users->phone }}" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Location</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputName" placeholder="Location" name="location" value="{{ $users->location }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Password</label>
                  <div class="col-sm-10">
                    <label class="control-label none" for="inputError"><i class="fa fa-times-circle-o"></i> 
                    </label>
                    <input type="password" class="form-control password" id="inputEmail" placeholder="New Password" name="password">          
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Root admin</label>
                  <div class="col-sm-10">
                    <select name="isroot">
                      <option value="0" id="input_select_is_root_0">No</option>
                      <option value="1" id="input_select_is_root_1">Yes</option>
                    </select>
                    Yes: that mean you set full access to this account. No: this account depend on permission below.      
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">signature</label>
                  <div class="col-sm-10">
                    <textarea class="form-control input-sm" placeholder="Signature" name="signature" >{{ $users->signature }}</textarea>
                  </div>
                </div>
                <div class="form-group">
                 <label for="inputName" class="col-sm-2 control-label">About me</label>
                 <div class="col-sm-10">
                  <textarea class="form-control input-sm" placeholder="About me" name="biography">{{ $users->biography }}</textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-12">
                  <label for="inputName" class="col-sm-2 control-label">Avatar</label>
                  <div class="col-sm-10">
                    <input placeholder="Avatar" type="file" name="image">
                  </div>
                </div>
              </div>
              <div class="form-group" >
               <label for="inputName" class="col-sm-2 control-label">Permission</label>
               <div class="col-sm-10" id="update_permission">
                 <table width="100%" cellspacing="0" cellpadding="8" class="wrap-user-permission">
                  <!--Make sure this source  match with file resources/pages/user/groups/edit.blade.php -->
                  <tr>
                    <?php echo permission_td("Users", "users_", "#BBBBBB") ?>
                    <?php echo permission_td("Users")  ?>
                    <?php echo permission_td("Read", "user_read", "#FFF7E8")?>  
                    <?php echo permission_td("Add", "user_add", "#0080ff")?>  
                    <?php echo permission_td("Edit", "user_edit", "#CAF2D9") ?>
                    <?php echo permission_td("Delete", "user_delete", "#F5CDCD")?>  
                  </tr>
                  <tr>
                   <?php echo permission_td("")  ?>
                   <?php echo permission_td("Groups")  ?>
                   <?php echo permission_td("Read", "user_groups", "#FFF7E8")?> 
                   <?php echo permission_td("Add", "user_group_add", "#0080ff")?>  
                   <?php echo permission_td("Edit", "user_group_edit", "#CAF2D9") ?>
                   <?php echo permission_td("Delete", "user_group_delete", "#F5CDCD")?> 
                 </tr>
                 <tr>
                  <?php echo permission_td("Domains",'',"#BBBBBB")  ?>
                  <?php //echo permission_td("Domains", "domains_", "#BBBBBB") ?>
                  <?php echo permission_td("Domains")  ?>
                  <?php echo permission_td("Read", "account_domains", "#FFF7E8")?> 
                  
                  <?php echo permission_td("Edit", "account_domain_edit", "#CAF2D9") ?>
                  <?php echo permission_td("Delete", "account_domain_delete", "#F5CDCD")?> 
                  <?php //echo permission_td("", "account_domain_add", "#FFF7E8")?>  
                </tr>
                <tr>
                 <?php echo permission_td("")  ?>
                 <?php echo permission_td("Record")  ?>
                 <?php echo permission_td("Add", "account_record_add", "#0080ff")?> 
                 <?php echo permission_td("Edit", "account_record_edit", "#CAF2D9")?> 
                 <?php echo permission_td("Delete", "account_record_delete", "#F5CDCD")?> 
               </tr>
               <tr>
                 <?php echo permission_td("")  ?>
                 <?php echo permission_td("Logs")  ?>
                 <?php echo permission_td("Read", "account_logs", "#FFF7E8")?> 
               </tr>
               <tr>
                 <?php echo permission_td("Settings", "", "#BBBBBB") ?>
                 <?php echo permission_td("Configuration")  ?>
                 <?php echo permission_td("Edit", "settings_edit", "#caf2d9")?> 
               </tr>
               <tr>
                 <?php echo permission_td("Synchronize", "synchronize_", "#BBBBBB") ?>
                 <?php echo permission_td("Synchronize")  ?>
                 <?php echo permission_td("Read", "synchronize_read", "#FFF7E8")?> 
                 <?php echo permission_td("Synchronize", "synchronize_edit", "#CAF2D9")?> 
                 <?php echo permission_td("Delete", "synchronize_delete", "#F5CDCD")?> 
               </tr>  
             </table>
           </div>
           <script language="javascript">
            <!--
            @foreach ($permission as $p=>$v)
            document.getElementById("{{ $p }}").checked = "checked";
            @endforeach
          -->
        </script>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-danger">Save</button>
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
<script language="javascript">
  <!--
  document.getElementById("input_select_is_root_{{$users->is_root}}" ).selected = "selected";  
  document.getElementById("input_select_{{$users->group_id}}" ).selected = "selected";   
  //document.getElementById("cat_id_" + {$data['cat_id']} ).selected = "selected";
//-->
</script>

<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.js"></script>
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script language="javascript">
 $(function () {
  $("[data-mask]").inputmask();
  $('.change-password').click(function(){
     // alert($('input.password').val());
     if($('input.password').val()=='' || ($('input.password').val()!=$('input.repassword').val() ))
     {
      $('input.password').parent().addClass('has-error');
      $('.label-password').html('Please make sure your passwords match');  
      $('input.repassword').parent().addClass('has-error');
      return false;
    }
      //alert($('input.password').val().length);
      if($('input.password').val().length<6)
      {
        $('input.password').parent().addClass('has-error');
        $('.label-password').html('Please enter at least 6 characters.');
        return false;     
      }
      $('input.password').parent().removeClass('has-error');
      $('input.repassword').parent().removeClass('has-error');
      if($('input.oldpassword').val()=='')
      {
        $('input.oldpassword').parent().addClass('has-error');
        $('.label-oldpassword').html('Enter your current password.');
        return false;
      }
      if($('input.oldpassword').val().length<6)
      {
        $('input.oldpassword').parent().addClass('has-error');
        $('.label-oldpassword').html('Please enter at least 6 characters.');
        
        return false;
      }
      return true;
    })
});
 var url_check_anchor=window.location.href;
 var url_hash = url_check_anchor.substring(url_check_anchor.indexOf("#")+1);
 if(url_hash=='changepass'||url_hash=='settings')
 {
  $('.nav-tabs li').removeClass('active');
  $('.tab-pane').removeClass('active');
  $('.nav-tabs li.li-'+url_hash).addClass('active');
  $('#'+url_hash).addClass('active');
}
else
{
  $('.nav-tabs li').removeClass('active');
  $('.nav-tabs li.li-activity').addClass('active');
}
</script>
<!-- /.content-wrapper -->
@stop