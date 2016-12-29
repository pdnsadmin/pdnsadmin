@section('title')
Your domains
@stop
@extends('pages.general.master')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Domains  
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/account')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{url('/account')}}/domains">Domains</a></li>   
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Domains</h3>
          </div>
          @if(Session::has('success'))
          <div class="alert alert-success">
            <div>{!! Session::get('success') !!}</div>
          </div>
          @endif
          @if(Session::has('error'))
          <p class="alert alert-danger">{!! Session::get('error') !!}</p>
          @endif
          <div class="box-body">
            <div class="row">
              <div class="col-md-12 col-lg-12 col-sm-12  col-sx-12 show_error_domain"></div>
              {!! Form::open(array('url' => 'account/domain/add','class'=>'add-new-domain')) !!}
              <div class="col-md-5  col-lg-5 col-sm-5  col-sx-12">
                <div class="form-group">
                  <label for="domainname">Domain</label>

                  <div class="input-group">
                   <div class="input-group-addon">
                    <i class="fa fa-external-link"></i>
                  </div>
                  <input type="text" class="form-control" id="domainname" placeholder="Domain name" name="domain">
                </div>
              </div>
            </div> 
            <div class="col-md-2  col-lg-2 col-sm-2  col-sx-12">
              <div class="form-group">
                <label>&nbsp</label>
                <div class="input-group box-submit">
                 <button type="submit" class="btn btn-info pull-right add-domain" >Add</button>
               </div>
             </div>
           </div>
           {{ Form::close() }}
         </div>
         <script language="javascript">
          <!--
          $(document).ready(function(){
            $('.add-domain').click(function(){
              var domain_value  = $('#domainname').val();
              
              if(domain_value==null || domain_value==''||!check_domain(domain_value))
              {
               $('.show_error_domain').html('Please enter a valid domain name. For example novaweb.vn');
               return false;
             }

             $('.box-submit').append('<div class="loading-for-waiting"></div>');
             $( ".add-domain" ).prop( "disabled", true );
             
             var ajax_url=$('form.add-new-domain').attr('action');
             var xdata=$('form.add-new-domain').serialize();
             $.post(ajax_url,xdata).done(function(data){
              $('.box-submit .loading-for-waiting').remove();
              $( ".add-domain" ).prop( "disabled", null );
              $('#domainname').val('');
              var response=jQuery.parseJSON(data);
              if(typeof response =='object')
              { 
                        // It is JSON
                        //alert(response.error);
                        if (typeof response.error != 'undefined'&&response.error!=null)
                        {
                           // alert('xxxtt');
                           $('.show_error_domain').html('<div class="alert alert-danger">'+response.error+'</div>');
                           return false;
                         } 
                         else
                         {   
                          $('.show_error_domain').html('<div class="alert alert-success">'+'You have been created domain: '+response.data.name+'</div>');
                          $('#example1 tbody').prepend('<tr role="row" class="odd"><td class="sorting_1"><a href="{{url("account/domain/edit")}}/'+response.data.id+'">'+response.data.name+'</a></td><td>Free website</td><td>'+response.data.created_at+'</td><td>'+response.data.updated_at+'</td><td><a href="{{url("account/domain/edit")}}/'+response.data.id+'"><i class="fa fa-fw fa-edit"></i></a><a href="javascript:void(0)" onclick="return confirmdelete('+"'{{url('account/domain/delete')}}/"+response.data.id+"'"+');"><i class="fa fa-fw fa-remove"></i></a> </td></tr>');
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
            <th>Domain Name</th>
            <th>Plan</th>
            <th>Added</th>
            <th>Modified</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($domains as $domain)
          <tr>
            <td><a href="{{url('account/domain/edit')}}/{{ $domain->id }}" title="Detail">{{ $domain->name }}</a></td>
            <td>Free Website</td>
            <td>{{ $domain->created_at }}</td>
            <td>{{ $domain->updated_at }}</td>
            <td>
              <a href="{{url('account/domain/edit')}}/{{ $domain->id }}"><i class="fa fa-fw fa-edit"></i></a> 
              <a href="javascript:void(0)" onclick="return confirmdelete('{{url('account/domain/delete')}}/{{ $domain->id }}');"><i class="fa fa-fw fa-remove"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
        <tfoot class="none">
          <tr>
           <th>Domain Name</th>  
           <th>Plan</th>
           <th>Added</th>
           <th>Modified</th>
           <th>Action</th>
         </tr>
       </tfoot>
     </table>
     <div class="pagination">{!! $domains->render() !!}</div>
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