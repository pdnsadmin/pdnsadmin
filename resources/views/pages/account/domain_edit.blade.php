@section('title')
Edit: {{ $domains->name }}
@stop
@extends('pages.general.master')
@section('content')
<script language="javascript">
  var domain_id={{ $domains->id }};
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Domain 
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/account')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{url('/account')}}/domains">Domains</a></li>
      <li>{{ $domains->name }}</li>  
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Domain: {{ $domains->name }} 
              <a href="javascript:void(0)" onclick="return confirmdelete('{{url('account/domain/delete')}}/{{ $domains->id }}');"><i class="fa fa-fw fa-remove"></i></a> </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                @if($msg_maximum)
                <div class="col-md-12  col-lg-12 col-sm-12  col-sx-12">
                  <div class=" alert alert-danger">{{ $msg_maximum }}</div>
                </div>
                @endif
                <div class="col-md-1  col-lg-1 col-sm-1  col-sx-12">
                  <div class="form-group ">
                    <label for="domaintype">Type</label>
                    <div class="input-group">{{ $records->type }}</div>
                  </div>     
                </div>
                <div class="col-md-3  col-lg-3 col-sm-3  col-sx-12">
                  <div class="form-group">
                    <label for="domainname">Domain</label>
                    <div class="input-group">
                      {{ $records->name }}
                    </div>
                  </div>
                </div> 
                <div class="col-md-7  col-lg-7 col-sm-7  col-sx-12">
                  <div class="form-group">
                    <label>Content</label>
                    <div class="input-group">
                     {{ $records->records[0]->content }}
                   </div>
                 </div>
               </div>
               <div class="col-md-1  col-lg-1 col-sm-1  col-sx-12">
                 <div class="form-group">
                  <label>TTL</label>
                  <div class="input-group">
                   {{ $records->ttl }}
                 </div>
               </div> 
             </div>
             <div class="none form-update-record">
              {!! Form::open(array('url' => 'account/domain/update_record','class'=>'update-record')) !!}
              <input type="text" name="content" class="form-control input-edit-record pull-left" data-mask>
              <div class="box-update-record">
               <button type="submit" class="btn btn-info pull-left button-update-record">Update</button>
             </div>
             {{ Form::close() }}
           </div>
           <div class="clearfix"></div>
           <div class="col-md-12  col-lg-12 col-sm-12  col-sx-12 domain-error-msg"></div>
           {!! Form::open(array('url' => 'account/domain/add_record','class'=>'add-new-record')) !!}
           <input type="hidden" name="id" value="{{ $domains->id }}" class="domain_id">
           <div class="col-md-1  col-lg-1 col-sm-1  col-sx-12">
            <div class="form-group">
              <label for="domaintype">Type</label> 
              <div class="input-group">
                <div class="dropdown-toggle button-domain-type-lable" data-toggle="dropdown">
                  <div class="col-md-8  col-lg-8 col-sm-8 col-sx-8 no-padding">
                    <div class="form-control box1"><span class="domain-type-lable">A</span></div>
                  </div>
                  <div class="col-md-4  col-lg-4 col-sm-4 col-sx-4 no-padding">
                    <div class="form-control box2"> 
                      <div class="fa fa-caret-up"></div>
                      <div class="fa fa-caret-down"></div>  
                    </div>  
                  </div>
                  <div class="clearfix"></div>
                </div>
                <ul class="record_dropdown dropdown-menu">
                  <li><a href="javascript:void(0)" class="domain-type" rel="A">A</a></li>
                  <li><a href="javascript:void(0)" class="domain-type" rel="AAAA">AAAA</a></li>
                  <li><a href="javascript:void(0)" class="domain-type" rel="CNAME">CNAME</a></li>
                  <li><a href="javascript:void(0)" class="domain-type" rel="MX">MX</a></li>
                  <li><a href="javascript:void(0)" class="domain-type" rel="LOC">LOC</a></li>
                  <li><a href="javascript:void(0)" class="domain-type" rel="SRV">SRV</a></li>
                  <li><a href="javascript:void(0)" class="domain-type" rel="SPF">SPF</a></li>
                  <li><a href="javascript:void(0)" class="domain-type" rel="TXT">TXT</a></li>
                  <li><a href="javascript:void(0)" class="domain-type" rel="NS">NS</a></li>
                </ul>
                <input type="hidden" name="domain-type" value="A" class="domain-type-value">
              </div> 
            </div>
          </div> 
          <div class="col-md-4  col-lg-4 col-sm-4  col-sx-12">
            <div class="form-group">
              <label for="domainname">Name</label>
              <div class="input-group class-for-srv">
                <input type="text" class="form-control record-name required" name="name" placeholder="Name"  oninput="check_empty(this.value)"><div class="input-group-addon class-domain-name">
                .{{ $domains->name }}
              </div>
            </div>
          </div>
        </div>  
        <div class="col-md-4  col-lg-4 col-sm-4  col-sx-12">
          <div class="form-group">
            <label class="label-cotent">IP mask:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-laptop"></i>
              </div>
              <input type="text" class="ipaddress4 form-control input-content class-A check-ip-address-4" data-inputmask="'alias': 'ip'" data-mask placeholder="IPv4 Address" name="content" oninput="show_hide_popup(this.value);" >
              <input type="text" class="form-control input-content none class-AAAA check-ip-address-6" placeholder="IPv6 Address" name="content">
              <input type="text" class="form-control input-content none class-CNAME check-domain-name" placeholder="Domain name" name="content">
              <input type="text" class="form-control input-content none class-NS check-server-name" placeholder="Input your NameServer" name="content">
              <input type="text" class="form-control input-content none class-MX check-content-mx" placeholder="Click to config" name="content" data-toggle="modal" data-target="#myMX" data-backdrop="static" data-keyboard="false">
              <input type="text" class="form-control input-content none class-TXT check-content-txt" placeholder="Click to config" name="content" data-toggle="modal" data-target="#myTXT" data-backdrop="static" data-keyboard="false">
              <input type="text" class="form-control input-content none class-SRV check-content-srv" placeholder="Click to config" name="content" data-toggle="modal" data-target="#mySRV" data-backdrop="static" data-keyboard="false">
              <input type="text" class="form-control input-content none class-SPF check-content-spf" placeholder="Click to config" name="content" data-toggle="modal" data-target="#mySPF" data-backdrop="static" data-keyboard="false">
              <input type="text" class="form-control input-content none class-LOC check-content-loc" placeholder="Click to config" name="content" data-toggle="modal" data-target="#myLOC" data-backdrop="static" data-keyboard="false">                          
              <input type="text" class="form-control input-content none class-general check-content-general" placeholder="Content" name="content">
            </div>
          </div>
        </div>
        <div class="col-md-2  col-lg-2 col-sm-2  col-sx-12">
          <?php $ttl_user=Auth::user()->ttl;?>
          <div class="form-group">
            <label for="ttl">TTL</label>
            <div class="input-group">
              <div class="dropdown-toggle button-domain-tll-lable" data-toggle="dropdown">
                <div class="col-md-8  col-lg-8 col-sm-8 col-sx-8 no-padding">
                  <div class="form-control box1"><span class="domain-tll-lable">{{ $ttl_text }}</span></div>
                </div>
                <div class="col-md-4  col-lg-4 col-sm-4 col-sx-4 no-padding">
                  <div class="form-control box2"> 
                    <div class="fa fa-caret-up"></div>
                    <div class="fa fa-caret-down"></div>  
                  </div>  
                </div>
                <div class="clearfix"></div>
              </div>
              <ul class="record_dropdown dropdown-menu">
                <li><a href="javascript:void(0)" class="domain-tll" rel="120">2 minutes @if($ttl_user==120) (Automatic TTL)  @endif</a></li>
                <li><a href="javascript:void(0)" class="domain-tll" rel="300">5 minutes @if($ttl_user==300) (Automatic TTL)  @endif</a></li>
                <li><a href="javascript:void(0)" class="domain-tll" rel="600">10 minutes @if($ttl_user==600) (Automatic TTL)  @endif</a></li>
                <li><a href="javascript:void(0)" class="domain-tll" rel="900">15 minutes @if($ttl_user==900) (Automatic TTL)  @endif</a></li>
                <li><a href="javascript:void(0)" class="domain-tll" rel="1800">30 minutes @if($ttl_user==1800) (Automatic TTL)  @endif</a></li>
                <li><a href="javascript:void(0)" class="domain-tll" rel="3600">1 hour @if($ttl_user==3600) (Automatic TTL)  @endif</a></li>
                <li><a href="javascript:void(0)" class="domain-tll" rel="7200">2 hours @if($ttl_user==7200) (Automatic TTL)  @endif</a></li>
                <li><a href="javascript:void(0)" class="domain-tll" rel="18000">5 hours @if($ttl_user==18000) (Automatic TTL)  @endif</a></li>
                <li><a href="javascript:void(0)" class="domain-tll" rel="43200">12 hours @if($ttl_user==43200) (Automatic TTL)  @endif</a></li>
                <li><a href="javascript:void(0)" class="domain-tll" rel="86400">1 day @if($ttl_user==86400) (Automatic TTL)  @endif</a></li>
              </ul>
              <input type="hidden" name="ttl" value="{{ $ttl_user }}" class="domain-tll-value">
            </div> 
          </div>
        </div>
        <div class="col-md-1  col-lg-1 col-sm-1  col-sx-12">
          <div class="form-group">
            <label>&nbsp</label>
            <div class="input-group box-submit">
             <button type="submit" class="btn btn-info pull-right add-record-domain">Add</button>
           </div>
         </div>
       </div>
     </div>
     {{ Form::close() }}
     <div class="clearfix"></div>
     <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Type</th>
          <th>Name</th>
          <th>Content</th>
          <th>TTL</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($domains->rrsets as $rrsets)
        @if($rrsets->type!='SOA')
        <tr id="delete{{ str_replace('.','-',trim($rrsets->name,'.')) }}">
         <td class="box-{{ $rrsets->type }}-record">{{ $rrsets->type }}</td> 
         <td>{{ trim($rrsets->name,'.') }}</td>
         <td>
          <span class="edit-content" id="{{ str_replace('.','-',trim($rrsets->name,'.')) }}"><span class="show-content">{{ trim($rrsets->records[0]->content,'.') }}</span>
          <span class="need-remove-before">
           <input type="hidden" name="recordcontent" value="{{ trim(trim($rrsets->records[0]->content,'.'),'"') }}" class="recordcontent">
           <input type="hidden" name="type" value="{{ $rrsets->type }}" class="type">
           <input type="hidden" name="name" value="{{ trim($rrsets->name,'.') }}" class="record-name">
           <input type="hidden" name="class_return" value="{{ str_replace('.','-',trim($rrsets->name,'.')) }}" class="class_return">
           <input type="hidden" name="ttl" value="{{ $rrsets->ttl }}" class="ttl">
         </span>
       </span>
     </td>
     <td>{{ $rrsets->ttl }}</td>
     <td><a href="javascript:void(0)" divdelete="delete{{ str_replace('.','-',trim($rrsets->name,'.')) }}" deleteid="{{ $domains->id }}" title="Delete" type="{{ $rrsets->type }}" name="{{ $rrsets->name }}" ttl="{{ $rrsets->ttl }}" content="{{ trim($rrsets->records[0]->content,'"') }}" class="click-to-delete">Delete</a></td>
   </tr>
   @endif
   @endforeach
 </tbody>
 <tfoot class="none">
  <tr>
    <th>Type</th>
    <th>Name</th>
    <th>Content</th>
    <th>TTL</th>
    <th>Action</th>
  </tr>
</tfoot>
</table>
</div>
</div>
</div>
</div>
</section>
<!-- /.content -->
</div>
<!--myMX record-->
<div class="modal fade" id="myMX" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Record: MX content</h4>
      </div>
      <div class="modal-body ">
        <div class="error-mailserver"></div>
        <div class="form-group">
         <div class="row">
          <label class="control-label col-sm-1 padding-top-5px">Server:</label>
          <div class="col-sm-11">
            <input type="text" class="form-control" placeholder="Mail server" name="mailserver"></div>
          </div>                              
        </div>
        <div class="error-priority"></div>
        <div class="form-group">
          <div class="row">
            <div class="col-sm-1"><label class="padding-top-5px">Priority:</label></div>
            <div class="col-sm-2">
             <input type="text" class="form-control" placeholder="Priority" size="5" name="priority" value="1">
           </div>
         </div> 
       </div>
     </div>
     <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary">Save changes</button>
    </div>
  </div>
</div>
</div>
<!-- myMXedit record-->
<div class="modal fade" id="myMXedit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Record: MX content</h4>
      </div>
      <div class="modal-body">
        <div class="error-edit-mailserver"></div>
        <div class="form-group">
          <div class="row">
            <label class="label-content col-sm-1 padding-top-5px">Server:</label>
            <div class="col-sm-11">   <input type="text" class="form-control" placeholder="Mail server" name="mailserver"></div>
          </div>
        </div>
        <div class="error-edit-priority"></div>
        <div class="form-group">
         <div class="row">
           <div class="col-sm-1"> <label class="label-content padding-top-5px">Priority:</label></div>
           <div class="col-sm-2">   <input type="text" class="form-control" placeholder="Priority" size="5" name="priority" value="1"></div>
         </div>              
       </div>
     </div>
     <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary">Save changes</button>
    </div>
  </div>
</div>
</div>
<!--Txt record-->
<div class="modal fade" id="myTXT" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Record: TXT content</h4>
      </div>
      <div class="modal-body">
        <div class="error-txtcontent"></div>
        <div class="form-group">
          <label class="label-cotent">Content:</label>                 
          <textarea class="form-control" placeholder="Text" name="contenttxt"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!--Txt edit record-->
<div class="modal fade" id="myTXTedit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Record: TXT content</h4>
      </div>
      <div class="modal-body">
        <div class="error-edit-txtcontent"></div>
        <div class="form-group">
          <label class="label-cotent">Content:</label>                 
          <textarea class="form-control" placeholder="Text" name="contenttxt"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!--SRV form-->
<div class="modal fade" id="mySRV" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Record: SRV name</h4>
      </div>
      <div class="modal-body">
        <div class="error-srvservicename"></div>
        <div class="form-group">
          <label class="label-cotent">Service name:</label>                 
          <input type="text" class="form-control" placeholder="_sip" name="servicename">
        </div>
        <div class="error-srvname"></div>
        <div class="form-group">
         <div class="row">
          <div class="col-md-2 col-lg-2 col-sm-2 col-sx-2">
            <!--Start--> 
            <label for="domaintype">Protocol</label>  
            <div class="dropdown-toggle button-protocol-type-lable" data-toggle="dropdown">
              <div class="col-md-8  col-lg-8 col-sm-8 col-sx-8 no-padding">
                <div class="form-control box1"><span class="protocol-type-lable">TCP</span></div>
              </div>
              <div class="col-md-4  col-lg-4 col-sm-4 col-sx-4 no-padding">
                <div class="form-control box2"> 
                  <div class="fa fa-caret-up"></div>
                  <div class="fa fa-caret-down"></div>  
                </div>  
              </div>       
            </div>
            <ul class="record_dropdown dropdown-menu">
              <li><a href="javascript:void(0)" class="protocol-type" rel="_tcp">TCP</a></li>
              <li><a href="javascript:void(0)" class="protocol-type" rel="_udp">UDP</a></li>
              <li><a href="javascript:void(0)" class="protocol-type" rel="_tls">TLS</a></li>
            </ul>
            <input type="hidden" name="protocol-type" value="_tcp" class="protocol-type-value"> 
          </div>
          <!--End-->
          <div class="col-md-10 col-lg-10 col-sm-10 col-sx-10">
            <label class="label-cotent">Name:</label>                 
            <input type="text" class="form-control" placeholder="@" name="srvname" value="{{$domains->name}}">
          </div>
        </div>
      </div>  
    </div> 
    <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel">Add Record: SRV content</h4>
    </div>
    <div class="modal-body">
      <div class="form-group">
       <div class="error-srvpriority"></div>
       <div class="row">
        <div class="col-md-6 col-lg-6 col-sm-6 col-sx-4">
          <label class="label-cotent">Priority:</label>                 
          <input type="text" class="form-control" placeholder="1" name="srvpriority" value="1">
        </div>
        <div class="col-md-6 col-lg-6 col-sm-6 col-sx-4">
          <label class="label-cotent">Weight:</label>                 
          <input type="text" class="form-control" placeholder="10" name="srvweight" value="1">
        </div>
        <div class="col-md-6 col-lg-6 col-sm-6 col-sx-4">
          <label class="label-cotent">Port:</label>                 
          <input type="text" class="form-control" placeholder="8444" name="srvport" value="1">
        </div>
        <div class="col-md-6 col-lg-6 col-sm-6 col-sx-12">
          <label class="label-cotent">Target:</label>                 
          <input type="text" class="form-control" placeholder="example.com" name="srvtarget" value="{{ $domains->name }}">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Save changes</button>
  </div>
</div>
</div>
</div>
<!--SRV edit form-->
<div class="modal fade" id="mySRVedit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <div class="modal-header">     
      <h4 class="modal-title" id="myModalLabel">Edit Record: SRV content</h4>
    </div>
    <div class="modal-body">
      <div class="form-group">
       <div class="error-editsrvpriority"></div>
       <div class="row">
        <div class="col-md-6 col-lg-6 col-sm-6 col-sx-4">
          <label class="label-cotent">Priority:</label>                 
          <input type="text" class="form-control" placeholder="1" name="srvpriority" value="1">
        </div>
        <div class="col-md-6 col-lg-6 col-sm-6 col-sx-4">
          <label class="label-cotent">Weight:</label>                 
          <input type="text" class="form-control" placeholder="10" name="srvweight" value="1">
        </div>
        <div class="col-md-6 col-lg-6 col-sm-6 col-sx-4">
          <label class="label-cotent">Port:</label>                 
          <input type="text" class="form-control" placeholder="8444" name="srvport" value="1">
        </div>
        <div class="col-md-6 col-lg-6 col-sm-6 col-sx-12">
          <label class="label-cotent">Target:</label>                 
          <input type="text" class="form-control" placeholder="example.com" name="srvtarget" value="{{ $domains->name }}">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Save changes</button>
  </div>
</div>
</div>
</div>
<!--SPF form-->
<div class="modal fade" id="mySPF" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Record: SPF content</h4>
      </div>
      <div class="modal-body">
        <div class="error-spfcontent"></div>
        <div class="form-group">
          <label class="label-cotent">Content:</label>                 
          <textarea class="form-control" placeholder="Policy parameters" name="contentspf"></textarea>
        </div>       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!--SPF edit form-->
<div class="modal fade" id="mySPFedit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Record: SPF content</h4>
      </div>
      <div class="modal-body">
        <div class="error-editspfcontent"></div>
        <div class="form-group">
          <label class="label-cotent">Content:</label>                 
          <textarea class="form-control" placeholder="Policy parameters" name="contentspf"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!--LOC form-->
<div class="modal fade" id="myLOC" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Record: LOC content</h4>
      </div>
      <div class="modal-body">
        <div class="error-loccontent"></div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-sx-12">
              <div class="error-loclat"></div>
            </div>
            <div class="col-md-12 col-lg-12 col-sm-12 col-sx-12">
              <label class="label-cotent">Latitude</label> 
            </div>
            <div class="col-md-3 col-lg-3 col-sm-3 col-sx-6">
              <label class="label-cotent">degrees:</label>                 
              <input type="text" class="form-control" placeholder="1" name="latdegrees" value="1">
            </div>
            <div class="col-md-3 col-lg-3 col-sm-3 col-sx-6">
              <label class="label-cotent">minutes:</label>                 
              <input type="text" class="form-control" placeholder="10" name="latminutes" value="1">
            </div>
            <div class="col-md-3 col-lg-3 col-sm-3 col-sx-6">
              <label class="label-cotent">seconds:</label>                 
              <input type="text" class="form-control" placeholder="8444" name="latseconds" value="1">
            </div>
            <div class="col-md-3 col-lg-3 col-sm-3 col-sx-6">
              <div class="row">
               <label for="domaintype">direction</label>  
               <div class="input-group">
                <div class="dropdown-toggle button-lat-direction-type-lable" data-toggle="dropdown">
                  <div class="col-md-8  col-lg-8 col-sm-8 col-sx-8 no-padding">
                    <div class="form-control box1"><span class="lat-direction-type-lable">South</span></div>
                  </div>
                  <div class="col-md-4  col-lg-4 col-sm-4 col-sx-4 no-padding">
                    <div class="form-control box2"> 
                      <div class="fa fa-caret-up"></div>
                      <div class="fa fa-caret-down"></div>  
                    </div>  
                  </div> 
                </div>
                <ul class="record_dropdown dropdown-menu">
                  <li><a href="javascript:void(0)" class="lat-direction-type" rel="S">South</a></li>
                  <li><a href="javascript:void(0)" class="lat-direction-type" rel="N">North</a></li>
                </ul>
                <input type="hidden" name="lat-direction-type" value="S" class="lat-direction-type-value">
              </div> 
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="row">
          <div class="col-md-12 col-lg-12 col-sm-12 col-sx-12">
            <div class="error-loclong"></div>
          </div>
          <div class="col-md-12 col-lg-12 col-sm-12 col-sx-12">
            <label class="label-cotent">Longitude</label> 
          </div>
          <div class="col-md-3 col-lg-3 col-sm-3 col-sx-6">
            <label class="label-cotent">degrees:</label>                 
            <input type="text" class="form-control" placeholder="1" name="longdegrees" value="1">
          </div>
          <div class="col-md-3 col-lg-3 col-sm-3 col-sx-6">
            <label class="label-cotent">minutes:</label>                 
            <input type="text" class="form-control" placeholder="10" name="longminutes" value="1">
          </div>
          <div class="col-md-3 col-lg-3 col-sm-3 col-sx-6">
            <label class="label-cotent">seconds:</label>                 
            <input type="text" class="form-control" placeholder="8444" name="longseconds" value="1">
          </div>
          <div class="col-md-3 col-lg-3 col-sm-3 col-sx-6">
            <div class="row">
             <label for="domaintype">direction</label>  
             <div class="input-group">
              <div class="dropdown-toggle button-long-direction-type-lable" data-toggle="dropdown">
                <div class="col-md-8  col-lg-8 col-sm-8 col-sx-8 no-padding">
                  <div class="form-control box1"><span class="long-direction-type-lable">East</span></div>
                </div>
                <div class="col-md-4  col-lg-4 col-sm-4 col-sx-4 no-padding">
                  <div class="form-control box2"> 
                    <div class="fa fa-caret-up"></div>
                    <div class="fa fa-caret-down"></div>  
                  </div>  
                </div> 
              </div>
              <ul class="record_dropdown dropdown-menu">
                <li><a href="javascript:void(0)" class="long-direction-type" rel="E">East</a></li>
                <li><a href="javascript:void(0)" class="long-direction-type" rel="W">West</a></li>
              </ul>
              <input type="hidden" name="long-direction-type" value="E" class="long-direction-type-value">
            </div> 
          </div>
        </div>
      </div>
    </div>
    <div class="form-group"> 
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-sx-12">
          <div class="error-localtitude"></div>
        </div>
        <div class="col-md-3 col-lg-3 col-sm-3 col-sx-6">
          <label class="label-cotent">Altitude(in meters):</label>                 
          <input type="text" class="form-control" placeholder="1" name="localtitude" value="1">
        </div>
        <div class="col-md-3 col-lg-3 col-sm-3 col-sx-6">
          <label class="label-cotent">Size(in meters):</label>                 
          <input type="text" class="form-control" placeholder="1" name="locsize" value="1">
        </div>
      </div>
    </div>  
    <div class="form-group">
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-sx-12">
          <div class="error-lochorizontal"></div>
        </div>
        <div class="col-md-12 col-lg-12 col-sm-12 col-sx-12">Precision (in meters)</div>
        <div class="col-md-6 col-lg-6 col-sm-6 col-sx-6">
         <label class="label-cotent">horizontal precision:</label>      
         <input type="text" class="form-control" placeholder="1" name="lochorizontal" value="1">
       </div>
       <div class="col-md-6 col-lg-6 col-sm-6 col-sx-6">
         <label class="label-cotent">vertical precision:</label>
         <input type="text" class="form-control" placeholder="1" name="locvertical" value="1">
       </div>
     </div>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Save changes</button>
  </div>
</div>
</div>
</div>
</div>
<!--LOC edit form-->
<div class="modal fade" id="myLOCedit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Record: LOC content</h4>
      </div>
      <div class="modal-body">
        <div class="error-editloccontent"></div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-sx-12">
              <div class="error-loclat"></div>
            </div>
            <div class="col-md-12 col-lg-12 col-sm-12 col-sx-12">
              <label class="label-cotent">Latitude</label> 
            </div>
            <div class="col-md-3 col-lg-3 col-sm-3 col-sx-6">
              <label class="label-cotent">degrees:</label>                 
              <input type="text" class="form-control" placeholder="1" name="latdegrees" value="1">
            </div>
            <div class="col-md-3 col-lg-3 col-sm-3 col-sx-6">
              <label class="label-cotent">minutes:</label>                 
              <input type="text" class="form-control" placeholder="10" name="latminutes" value="1">
            </div>
            <div class="col-md-3 col-lg-3 col-sm-3 col-sx-6">
              <label class="label-cotent">seconds:</label>                 
              <input type="text" class="form-control" placeholder="8444" name="latseconds" value="1">
            </div>
            <div class="col-md-3 col-lg-3 col-sm-3 col-sx-6">
              <div class="row">
               <label for="domaintype">direction</label>  
               <div class="input-group">
                <div class="dropdown-toggle button-lat-direction-type-lable" data-toggle="dropdown">
                  <div class="col-md-8  col-lg-8 col-sm-8 col-sx-8 no-padding">
                    <div class="form-control box1"><span class="lat-direction-type-lable">South</span></div>
                  </div>
                  <div class="col-md-4  col-lg-4 col-sm-4 col-sx-4 no-padding">
                    <div class="form-control box2"> 
                      <div class="fa fa-caret-up"></div>
                      <div class="fa fa-caret-down"></div>  
                    </div>  
                  </div> 
                </div>
                <ul class="record_dropdown dropdown-menu">
                  <li><a href="javascript:void(0)" class="lat-direction-type" rel="S">South</a></li>
                  <li><a href="javascript:void(0)" class="lat-direction-type" rel="N">North</a></li>
                </ul>
                <input type="hidden" name="lat-direction-type" value="S" class="lat-direction-type-value">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="row">
          <div class="col-md-12 col-lg-12 col-sm-12 col-sx-12">
            <div class="error-editloclong"></div>
          </div>
          <div class="col-md-12 col-lg-12 col-sm-12 col-sx-12">
            <label class="label-cotent">Longitude</label> 
          </div>
          <div class="col-md-3 col-lg-3 col-sm-3 col-sx-6">
            <label class="label-cotent">degrees:</label>                 
            <input type="text" class="form-control" placeholder="1" name="longdegrees" value="1">
          </div>
          <div class="col-md-3 col-lg-3 col-sm-3 col-sx-6">
            <label class="label-cotent">minutes:</label>                 
            <input type="text" class="form-control" placeholder="10" name="longminutes" value="1">
          </div>
          <div class="col-md-3 col-lg-3 col-sm-3 col-sx-6">
            <label class="label-cotent">seconds:</label>                 
            <input type="text" class="form-control" placeholder="8444" name="longseconds" value="1">
          </div>
          <div class="col-md-3 col-lg-3 col-sm-3 col-sx-6">
            <div class="row">
             <label for="domaintype">direction</label>  
             <div class="input-group">
              <div class="dropdown-toggle button-long-direction-type-lable" data-toggle="dropdown">
                <div class="col-md-8  col-lg-8 col-sm-8 col-sx-8 no-padding">
                  <div class="form-control box1"><span class="long-direction-type-lable">East</span></div>
                </div>
                <div class="col-md-4  col-lg-4 col-sm-4 col-sx-4 no-padding">
                  <div class="form-control box2"> 
                    <div class="fa fa-caret-up"></div>
                    <div class="fa fa-caret-down"></div>  
                  </div>  
                </div> 
              </div>
              <ul class="record_dropdown dropdown-menu">
                <li><a href="javascript:void(0)" class="long-direction-type" rel="E">East</a></li>
                <li><a href="javascript:void(0)" class="long-direction-type" rel="W">West</a></li>
              </ul>
              <input type="hidden" name="long-direction-type" value="E" class="long-direction-type-value">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group"> 
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-sx-12">
          <div class="error-editlocaltitude"></div>
        </div>
        <div class="col-md-3 col-lg-3 col-sm-3 col-sx-6">
          <label class="label-cotent">Altitude(in meters):</label>                 
          <input type="text" class="form-control" placeholder="1" name="localtitude" value="1">
        </div>
        <div class="col-md-3 col-lg-3 col-sm-3 col-sx-6">
          <label class="label-cotent">Size(in meters):</label>                 
          <input type="text" class="form-control" placeholder="1" name="locsize" value="1">
        </div>
      </div>
    </div>
    <div class="form-group"> 
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-sx-12">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-sx-12">
              <div class="error-editlochorizontal"></div>
            </div>
            <div class="col-md-12 col-lg-12 col-sm-12 col-sx-12">Precision (in meters)</div>
            <div class="col-md-6 col-lg-6 col-sm-6 col-sx-6">
             <label class="label-cotent">horizontal precision:</label>
             <input type="text" class="form-control" placeholder="1" name="lochorizontal" value="1">
           </div>
           <div class="col-md-6 col-lg-6 col-sm-6 col-sx-6">
             <label class="label-cotent">vertical precision:</label>
             <input type="text" class="form-control" placeholder="1" name="locvertical" value="1">
           </div>
         </div>
       </div>
     </div>        
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Save changes</button>
  </div>
</div>
</div>
</div>
</div>
<!--Edit -->
<!--myMX record-->
<!--End edit-->
<script src="{{url('themes')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.js"></script>
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="{{url('themes')}}/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<Script language="javascript">
  $(document).ready(function(){
    /*MX record*/  
    $('#myMX .modal-footer .btn-primary').on('click', function () {
      var mailserver  = $('#myMX input[name=mailserver]').val();
      var priority  = $('#myMX input[name=priority]').val();
      if(!check_domain(mailserver))
      {
       $('.error-mailserver').html('<div class="alert alert-danger">Please enter a valid domain name. For example novaweb.vn</div>');
       return false; 
     }
     $('.error-mailserver').html('');
     if(!$.isNumeric(priority))
     {
      $('.error-priority').html('<div class="alert alert-danger">Priority must be a numeric</div>');
      return false; 
    }
    $('.error-priority').html('');
    $('.class-MX').val(priority+' '+mailserver);
    $( "#myMX .modal-footer .btn-default" ).trigger( "click" );
  })
    /*TXT record*/
    $('#myTXT .modal-footer .btn-primary').on('click', function () {
      var contenttxt  = $('#myTXT textarea[name=contenttxt]').val();
      if(contenttxt==null || contenttxt=='')
      {
       $('.error-txtcontent').html('<div class="alert alert-danger">Please fill out this field</div>');
       return false; 
     }
     $('.error-txtcontent').html('');
     $('.class-TXT').val(contenttxt);
     $( "#myTXT .modal-footer .btn-default" ).trigger( "click" );
   })
    /*SPF record*/
    $('#mySPF .modal-footer .btn-primary').on('click', function () {
      var contentspf  = $('#mySPF textarea[name=contentspf]').val();
      if(contentspf==null || contentspf=='')
      {
       $('.error-spfcontent').html('<div class="alert alert-danger">Please fill out this field</div>');
       return false; 
     }
     $('.error-spfcontent').html('');
     $('.class-SPF').val(contentspf);
     $( "#mySPF .modal-footer .btn-default" ).trigger( "click" );
   })
    /*Loc record*/
    $('.lat-direction-type').click(function(){
      var domain_rel=$(this).attr('rel');
      var domain_lable_lat='North';
      if(domain_rel=='S')
      {
       domain_lable_lat='South';
     }
     $('.lat-direction-type-lable').html(domain_lable_lat);
     $('.lat-direction-type-value').val(domain_rel);
   })
    $('.long-direction-type').click(function(){
      var domain_rel=$(this).attr('rel');
      var domain_lable_long='East';
      if(domain_rel=='W')
      {
       domain_lable_long='West';
     }
     $('.long-direction-type-lable').html(domain_lable_long);
     $('.long-direction-type-value').val(domain_rel);
   })
    $('#myLOC .modal-footer .btn-primary').on('click', function () {
     var latdegrees     =   $('#myLOC input[name=latdegrees]').val();
     var latminutes     =   $('#myLOC input[name=latminutes]').val();
     var latseconds     =   parseFloat($('#myLOC input[name=latseconds]').val());
     var latdirection   =   $('#myLOC input[name=lat-direction-type]').val();
     var longdirection  =   $('#myLOC input[name=long-direction-type]').val();

     var longdegrees    =   $('#myLOC input[name=longdegrees]').val();
     var longminutes    =   $('#myLOC input[name=longminutes]').val();
     var longseconds    =   parseFloat($('#myLOC input[name=longseconds]').val());

     var localtitude    =   parseFloat($('#myLOC input[name=localtitude]').val());   
     var locsize        =   parseFloat($('#myLOC input[name=locsize]').val());

     var lochorizontal  =   parseFloat($('#myLOC input[name=lochorizontal]').val());
     var locvertical    =   parseFloat($('#myLOC input[name=locvertical]').val());
     
     if(!$.isNumeric(latdegrees)||!$.isNumeric(latminutes)||!$.isNumeric(latseconds))
     {
      $('.error-loclat').html('<div class="alert alert-danger">Degrees, Minutes, Seconds must be a numeric</div>');
      return false; 
    }
    $('.error-loclat').html('');
    if(!$.isNumeric(longdegrees)||!$.isNumeric(longminutes)||!$.isNumeric(longseconds))
    {
      $('.error-loclong').html('<div class="alert alert-danger">Degrees, Minutes, Seconds must be a numeric</div>');
      return false; 
    }
    $('.error-loclong').html('');
    if(!$.isNumeric(localtitude)||!$.isNumeric(locsize))
    {
      $('.error-localtitude').html('<div class="alert alert-danger">Altitude, Size must be a numeric</div>');
      return false; 
    }
    $('.error-localtitude').html('');
    if(!$.isNumeric(lochorizontal)||!$.isNumeric(locvertical))
    {
      $('.error-lochorizontal').html('<div class="alert alert-danger">Altitude, Size must be a numeric</div>');
      return false; 
    }
    $('.error-lochorizontal').html('');
    $('.class-LOC').val(latdegrees+' '+latminutes+ ' '+latseconds.toFixed(3)+' '+latdirection+' '+longdegrees+' '+longminutes+ ' '+longseconds.toFixed(3)+' '+longdirection+ ' '+localtitude.toFixed(2)+'m'+ ' '+locsize.toFixed(2)+'m'+ ' '+lochorizontal.toFixed(2)+'m'+ ' '+locvertical.toFixed(2)+'m');
    $( "#myLOC .modal-footer .btn-default" ).trigger( "click" );
  })
    /*srv record*/
    $('.protocol-type').click(function(){
      var domain_rel=$(this).attr('rel');
      $('.protocol-type-lable').html(domain_rel);
      $('.protocol-type-value').val(domain_rel);
    })
    $('#mySRV .modal-footer .btn-primary').on('click', function () {
      var servicename   = $('#mySRV input[name=servicename]').val();
      var protocoltype  =$('.protocol-type-value').val();
      var srvname       = $('#mySRV input[name=srvname]').val();
      var srvpriority   = $('#mySRV input[name=srvpriority]').val();
      var srvweight     = $('#mySRV input[name=srvweight]').val();
      var srvport       = $('#mySRV input[name=srvport]').val();
      var srvtarget     = $('#mySRV input[name=srvtarget]').val();
                        // alert(contenttxt);              
                        if(servicename==null || servicename=='')
                        {
                         $('.error-srvservicename').html('<div class="alert alert-danger">Invalid SRV service name: SRV service name must start with an underscore.</div>');
                         return false; 
                       }
                       $('.error-srvservicename').html('');
                       if(srvname==null || srvname=='')
                       {
                         $('.error-srvname').html('<div class="alert alert-danger">Please fill out this field.</div>');
                         return false; 
                       }
                       $('.error-srvname').html('');
                       if(!$.isNumeric(srvpriority)||!$.isNumeric(srvweight)||!$.isNumeric(srvport))
                       {
                        $('.error-srvpriority').html('<div class="alert alert-danger">Priority, Weight, Port must be a numeric</div>');
                        return false; 
                      }
                      $('.error-srvpriority').html('');
                      if(srvtarget==null || srvtarget=='')
                      {
                       $('.error-srvpriority').html('<div class="alert alert-danger">Please fill out the Target field.</div>');
                       return false; 
                     }
                     $('.error-srvpriority').html('');
                     $('.class-for-srv input[name=name]').val(servicename+'.'+protocoltype+'.'+srvname);
                     $('.class-SRV').val(srvpriority+' '+srvweight+' '+srvport+' '+srvtarget);
                     $( "#mySRV .modal-footer .btn-default" ).trigger( "click" );
                   })   
    
    $('.domain-tll').click(function(){
      var domain_tll=$(this).attr('rel');
      switch(domain_tll) {
        case '120':   
        $('.domain-tll-lable').html('2 minutes');
        break;
        case '300':   
        $('.domain-tll-lable').html('5 minutes');
        break;
        case '600':   
        $('.domain-tll-lable').html('10 minutes');
        break;
        case '900':   
        $('.domain-tll-lable').html('15 minutes');
        break;
        case '1800':   
        $('.domain-tll-lable').html('30 minutes');
        break;
        case '3600':   
        $('.domain-tll-lable').html('1 hour');
        break;
        case '7200':   
        $('.domain-tll-lable').html('2 hours');
        break;
        case '18000':   
        $('.domain-tll-lable').html('5 hours');
        break;
        case '43200':   
        $('.domain-tll-lable').html('12 hours');
        break;
        case '86400':   
        $('.domain-tll-lable').html('1 day');
        break;
      }
      $('.domain-tll-value').val(domain_tll);
    })
    $('.domain-type').click(function(){
      var domain_rel=$(this).attr('rel');
      $('.domain-type-lable').html(domain_rel);
      $('.domain-type-value').val(domain_rel);
      switch(domain_rel) {
        case 'A':
        $('.add-new-record .label-cotent').html('IP mask:');
        $('.add-new-record .input-content').addClass('none');
        $('.add-new-record .class-'+domain_rel).removeClass('none');  
        break;
        case 'AAAA':
        $('.add-new-record .label-cotent').html('IP mask:');
        $('.add-new-record .input-content').addClass('none');
        $('.add-new-record .class-'+domain_rel).removeClass('none');
        break;
        case 'CNAME':
        $('.add-new-record .label-cotent').html('Domain name:');
        $('.add-new-record .input-content').addClass('none');
        $('.add-new-record .class-'+domain_rel).removeClass('none');
        break; 
        case 'NS':
        $('.add-new-record .label-cotent').html('Name Server:');
        $('.add-new-record .input-content').addClass('none');
        $('.add-new-record .class-'+domain_rel).removeClass('none');
        break;
        case 'MX':
        $('.add-new-record .label-cotent').html('Content:');
        $('.add-new-record .input-content').addClass('none');
        $('.add-new-record .class-'+domain_rel).removeClass('none');
        break;
        case 'TXT':
        $('.add-new-record .label-cotent').html('Content:');
        $('.add-new-record .input-content').addClass('none');
        $('.add-new-record .class-'+domain_rel).removeClass('none');
        break; 
        case 'SRV':
        $('.add-new-record .label-cotent').html('Content:');
        $('.add-new-record .input-content').addClass('none');
        $('.add-new-record .class-'+domain_rel).removeClass('none');
        break;  
        case 'SPF':
        $('.add-new-record .label-cotent').html('Content:');
        $('.add-new-record .input-content').addClass('none');
        $('.add-new-record .class-'+domain_rel).removeClass('none');
        break;  
        case 'LOC':
        $('.add-new-record .label-cotent').html('Content:');
        $('.add-new-record .input-content').addClass('none');
        $('.add-new-record .class-'+domain_rel).removeClass('none');
        break;            
        default:
        $('.add-new-record .label-cotent').html('Content:');
        $('.add-new-record .input-content').addClass('none');
        $('.add-new-record .class-general').removeClass('none');
        break;
      } 
      $('.check-ip-address-4').tooltip('destroy');
      $('.check-ip-address-6').tooltip('destroy');
      $('.check-domain-name').tooltip('destroy');
      $('.check-server-name').tooltip('destroy');
      $('.check-content-txt').tooltip('destroy');
      $('.check-content-mx').tooltip('destroy');
      $('.check-content-srv').tooltip('destroy');
      $('.check-content-spf').tooltip('destroy');
      $('.check-content-loc').tooltip('destroy');
      $('.check-content-general').tooltip('destroy');
      if(domain_rel=='SRV')
      {
        $('.class-for-srv').addClass('class-has-srv');
        $('.class-for-srv').removeClass('input-group');
        $('.class-for-srv input.form-control').attr('placeholder','Click to config');
        $('.class-for-srv input.form-control').attr('data-toggle','modal');
        $('.class-for-srv input.form-control').attr('data-target','#mySRV');
        $('.class-for-srv input.form-control').attr('data-backdrop','static');
        $('.class-for-srv input.form-control').attr('data-keyboard','false');
      }
      else
      {
        $('.class-for-srv').addClass('input-group');
        $('.class-for-srv').removeClass('class-has-srv'); 
        $('.class-for-srv input.form-control').attr('placeholder','name');
        $('.class-for-srv input.form-control').removeAttr('data-toggle');
        $('.class-for-srv input.form-control').removeAttr('data-target');
        $('.class-for-srv input.form-control').removeAttr('data-backdrop');
        $('.class-for-srv input.form-control').removeAttr('data-keyboard');
      }
    })
$('.add-record-domain').click(function(){
  var x_domain_rel  = $('.domain-type-value').val();
  var input_content = '';
  if(x_domain_rel=='A')
  {
    input_content=$('.class-A').val();
    if(!check_ip(input_content))
    {
      $('.check-ip-address-4').tooltip({ 
        placement: "top",
        title:'Invalid address: You must enter a valid IPv4 address.',
        trigger:'click',
      });  
      $('.check-ip-address-4').tooltip('show');
      return false;
    }
  }
  else if(x_domain_rel=='AAAA')
  {
    input_content=$('.class-AAAA').val();
    if(!checkipv6(input_content))
    {
      $('.check-ip-address-6').tooltip({ 
        placement: "top",
        title:'Invalid address: You must enter a valid IPv6 address.',
        trigger:'click',
      });  
      $('.check-ip-address-6').tooltip('show');
      return false;
    }  
  }
  else if(x_domain_rel=='CNAME')
  {
   input_content=$('.class-CNAME').val();
   if(!check_domain(input_content))
   {
     $('.check-domain-name').tooltip({ 
      placement: "top",
      title:'Please enter a valid domain name. For example novaweb.vn',
      trigger:'click',
    });  
     $('.check-domain-name').tooltip('show');
     return false;
   }  
 }
 else if(x_domain_rel=='MX')
 {
   input_content=$('.class-MX').val();
   if(input_content==null||!input_content||input_content=='')
   {
    $('.check-content-mx').tooltip({ 
      placement: "top",
      title:'This field is required',
      trigger:'click',
    });  
    $('.check-content-mx').tooltip('show');
    return false;
  }
}
else if(x_domain_rel=='TXT')
{
 input_content=$('.class-TXT').val();
 if(input_content==null||!input_content||input_content=='')
 {
  $('.check-content-txt').tooltip({ 
    placement: "top",
    title:'This field is required',
    trigger:'click',
  });  
  $('.check-content-txt').tooltip('show');
  return false;
}
}
else if(x_domain_rel=='SRV')
{
 input_content=$('.class-SRV').val();
 if(input_content==null||!input_content||input_content=='')
 {
  $('.check-content-srv').tooltip({ 
    placement: "top",
    title:'This field is required',
    trigger:'click',
  });  
  $('.check-content-srv').tooltip('show');
  return false;
}
}
else if(x_domain_rel=='SPF')
{
 input_content=$('.class-SPF').val();
 if(input_content==null||!input_content||input_content=='')
 {
  $('.check-content-spf').tooltip({ 
    placement: "top",
    title:'This field is required',
    trigger:'click',
  });  
  $('.check-content-spf').tooltip('show');
  return false;
}
}
else if(x_domain_rel=='LOC')
{
 input_content=$('.class-LOC').val();
 if(input_content==null||!input_content||input_content=='')
 {
  $('.check-content-loc').tooltip({ 
    placement: "top",
    title:'This field is required',
    trigger:'click',
  });  
  $('.check-content-loc').tooltip('show');
  return false;
}
}
else if(x_domain_rel=='NS')
{
  input_content=$('.class-NS').val();
  if(!check_domain(input_content))
  {
   $('.check-server-name').tooltip({ 
    placement: "top",
    title:'Please enter a valid domain name. For example novaweb.vn',
    trigger:'click',
  });  
   $('.check-server-name').tooltip('show');
   return false;
 }  
}
else
{
 input_content=$('.class-general').val();
 if(input_content==null||!input_content||input_content=='')
 {
  $('.check-content-general').tooltip({ 
    placement: "top",
    title:'This field is required',
    trigger:'click',
  });  
  $('.check-content-general').tooltip('show');
  return false;
}
}
var ajax_url= $('form.add-new-record').attr('action');
var xdata       = $('form.add-new-record').serialize();
var record_name = $('.record-name').val();
var xid         = $('.domain_id').val();
var  _token     = $("input[name=_token]").val();
var domain_type = $('.domain-type-value').val();
var ttl         = $('.domain-tll-value').val();
if(record_name=='')
{
  $('.record-name').tooltip({ 
    placement: "top",
    title:'Invalid hostname: Use @ to represent the root domain.',
    trigger:'click',
  });  
  $('.record-name').tooltip('show');
  return false;
}
$('.box-submit').append('<span class="loading-for-waiting"></span>');
$(".box-submit .add-record-domain" ).prop( "disabled", true );
$('.box-submit button').removeClass('btn-info');
$.post(ajax_url,{name:record_name,content:input_content,id:xid,_token:_token,type:domain_type,ttl:ttl}).done(function(data){
  $('.box-submit .loading-for-waiting').remove();
  $('.box-submit button').addClass('btn-info');
  $( ".box-submit .add-record-domain" ).prop( "disabled", null );
                          //alert(data);
                          var response=$.parseJSON(data);
                          if(response.error_status==1)
                          {
                            $('.domain-error-msg').html('<div class="alert alert-danger">'+response.error+'<div>');      
                          }
                          else/*if add record successful*/
                          {
                            $('.domain-error-msg').html('<div class="alert alert-success">'+response.error+'</div>'); 
                            $('#example1 tbody').prepend('<tr role="row" class="odd" id="delete'+response.data.divid+'"><td class="sorting_1 box-'+response.data.type+'-record">'+response.data.type+'</td><td>'+response.data.name+'</td><td><span class="edit-content" id="'+response.data.divid+'"><span class="show-content">'+response.data.content+'</span><span class="need-remove-before"><input type="hidden" name="recordcontent" class="recordcontent" value="'+response.data.content+'"><input type="hidden" name="type" value="'+response.data.type+'" class="type"><input type="hidden" name="name" value="'+response.data.name+'" class="record-name"><input type="hidden" name="name" value="'+response.data.divid+'" class="class_return"><input type="hidden" name="ttl" value="'+response.data.ttl+'" class="ttl"></span></span></td><td>'+response.data.ttl+'</td>><td><a href="javascript:void(0)" divdelete="delete'+response.data.divid+'" deleteid="{{ $domains->id }}" title="Delete" type="'+response.data.type+'" name="'+response.data.name+'." ttl="'+response.data.ttl+'" content="'+response.data.content+'" class="click-to-delete">Delete</a></td></tr>');  
                           //reset value
                           $('form.add-new-record .record-name').val('');
                           $('form.add-new-record .input-content').val('');
                           var rowCount = $('#example1 tbody tr').length;
                           if(rowCount>=15)
                           {
                            $('#example1 tfoot').removeClass('none');
                          }
                          else
                          {
                            $('#example1 tfoot').addClass('none');
                          }
                        }
                        return false;
                      })
return false;
})
})
</Script>  
<script src="{{url('themes')}}/records.js"></script>
@stop