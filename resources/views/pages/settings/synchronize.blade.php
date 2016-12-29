@section('title')
synchronize
@stop
@extends('pages.general.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Synchronize
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/account')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Synchronize</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!-- /.col -->
      <div class="col-md-8">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active li-activity"><a href="#activity" data-toggle="tab">Synchronize</a></li>   
          </ul>
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
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr> 
                      <th>Domain Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php $j=1;?>
                   @foreach ($array_diff_server as $k=>$v)
                   <tr class="domain-listed-on-server-{{ $j }}">  
                     <td>{{ $v }} </td>
                     <td>
                       <div class="input-group input-group-sm">
                        <input type="text" class="form-control user-assign ui-autocomplete-input" placeholder="Assaign to account? Type here to search">
                        <input type="hidden" name="domain" value="{{ $v }}" class="domain">
                        <span class="input-group-btn">
                          <button class="btn btn-block btn-warning button-sync-to-local" type="button" rel="{{ $j }}">Sync to local</button>
                        </span>
                        <?php $j++;?>
                      </div>    
                    </td>
                  </tr> 
                  @endforeach
                  @foreach ($array_diff_local as $k=>$v)
                  <tr class="domain-listed-on-local-{{ $j }}">
                   <td>{{ $v }} </td>
                   <input type="hidden" name="domain" value="{{ $v }}" class="domain">
                   <td><button  rel="{{ $j }}" class="btn btn-primary button-sync-to-server">Sync to server</button> <button  rel="{{ $j }}" class="btn btn-danger button-remove-from-local">Delete</button></td>
                   <?php $j++;?>
                 </tr> 
                 @endforeach
               </tbody>
             </table>
           </div>
         </div>
       </div>
     </div>
   </div>
 </div>
</div>
<!-- /.row -->
</section>
<!-- /.content -->
</div>
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.js"></script>
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- /.content-wrapper -->
@stop