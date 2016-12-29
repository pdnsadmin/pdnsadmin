@section('title')
Access rights
@stop
@extends('pages.general.master')
@section('content')
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
    //-->
  </script>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Groups 
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/account')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/user')}}/groups">Groups</a></li>   
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Group</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row"> 
                <div class="col-md-12">
                  {!! Form::open(array('url' => 'user/group/edit/','class'=>'update-group')) !!}
                  <input type="hidden" name="id" value="{{ $group->id }}">   
                  <div class="form-group">
                   @if(Session::has('success'))
                   <div class="alert alert-success">
                    <div>{!! Session::get('success') !!}</div>
                  </div>
                  @endif   
                  @if(Session::has('error'))
                  <p class="alert alert-danger">{!! Session::get('error') !!}</p>
                  @endif
                  
                  <table width="100%" cellspacing="0" cellpadding="8" class="wrap-user-permission">  
                    <tr>
                      <td><label for="grouptype" >Group</label></td>
                      <td><input type="text" class="form-control" value="{{ $group->name }}" name="name" required></td>
                    </tr>
                    <!--Make sure this source  match with file resources/pages/user/users/edit.blade.php -->
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
               <script language="javascript">
                <!--
                @foreach ($permission as $p=>$v)
                document.getElementById("{{ $p }}").checked = "checked";
                @endforeach
              -->
            </script>
          </div>              
          <div class="form-group ">
           <input type="submit" name="Update" value="Update" class="btn btn-info">
         </div>
         {{ Form::close() }}
       </div>
     </div>
   </div>
 </div>
</div>
</div>
</section>
</div>
@stop