@section('title')
Access rights
@stop
@extends('pages.general.master')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Groups  
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/account')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{url('/user/groups')}}">Groups</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Groups</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-md-12 col-lg-12 col-sm-12  col-sx-12 show_error_group"></div>
              {!! Form::open(array('url' => 'user/group/add','class'=>'add-new-group')) !!}
              <div class="col-md-5  col-lg-5 col-sm-5  col-sx-12">
                <div class="form-group">
                  <label for="groupname">Groups</label>

                  <div class="input-group">
                   <div class="input-group-addon">
                    <i class="fa fa-external-link"></i>
                  </div>
                  <input type="text" class="form-control" id="groupname" placeholder="group name" name="group">
                </div>
              </div>
            </div> 
            <div class="col-md-2  col-lg-2 col-sm-2  col-sx-12">
              <div class="form-group">
                <label>&nbsp</label>
                <div class="input-group box-submit">
                 <button type="submit" class="btn btn-info pull-right add-group" >Add</button>
               </div>
             </div>
           </div>
           {{ Form::close() }}
         </div>
         <script language="javascript">
          <!--
          $(document).ready(function(){
            $('.add-group').click(function(){
              var group_value  = $('#groupname').val();
              if(group_value==null || group_value=='')
              {
               $('.show_error_group').html('Please enter a valid group name');
               return false;
             }
             $('.box-submit').append('<span class="loading-for-waiting"></span>');
             var ajax_url=$('form.add-new-group').attr('action');
             var xdata=$('form.add-new-group').serialize();
             $.post(ajax_url,xdata).done(function(data){
              $('.box-submit .loading-for-waiting').remove();
              var response=jQuery.parseJSON(data);
              if(typeof response =='object')
              { 
                $('.show_error_group').html('<div class="alert alert-success">'+'You have been created group: '+response.name+'</div>');
                $('#example1 tbody').prepend('<tr role="row" class="odd"><td class="sorting_1"><a href="{{url("user/group/edit")}}/'+response.id+'">'+response.name+'</a></td><td>'+response.created_at+'</td><td>'+response.updated_at+'</td></tr>');
                $('.dataTables_empty').parent().remove();
                             //$('#example1').DataTable().ajax.reload();
                             var rowCount = $('#example1 tbody tr').length;
                             if(rowCount>=15)
                             {
                              $('#example1 tfoot').removeClass('none');
                            }
                            else
                            {
                              $('#example1 tfoot').addClass('none');
                            }

                            return false; 
                          }
                          else
                          {
                            if(response ===false)
                            {
                              alert(response);
                           // the response was a string "false", parseJSON will convert it to boolean false
                         }
                         else
                         {
                          alert(response);
                          // the response was something else
                        }
                      }
                      //alert(data);
                    })
             return false;
           })
          })
        -->
      </script>
      <div class="clearfix"></div>
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Group</th>
            <th>Added</th>
            <th>Modified</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($groups as $group)
          <tr>
            <td><a href="{{url('user/group/edit')}}/{{ $group->id }}" title="Detail">{{ $group->name }}</a></td>
            <td>{{ $group->created_at }}</td>
            <td>{{ $group->updated_at }}</td>
          </tr>
          @endforeach
        </tbody>
        <tfoot class="none">
          <tr>
           <th>Domain Name</th>
           <th>Added</th>
           <th>Modified</th>
         </tr>
       </tfoot>
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
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.js"></script>
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script>
  $(function () {
    $("[data-mask]").inputmask();
    $('#example1').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": false,
      "autoWidth": false,
      "fnDrawCallback":function(){
        var rowCount = $('#example1 tbody tr').length;
        if(rowCount>=15)
        {
          $('#example1 tfoot').removeClass('none');
        }
        else
        {
          $('#example1 tfoot').addClass('none');
        }
       // alert(rowCount);
     }
   });
    
  });
</script>
@stop