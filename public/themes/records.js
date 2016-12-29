$(function () {

  $('#myMXedit .modal-footer .btn-primary').on('click', function () {
    var mailserver  = $('#myMXedit input[name=mailserver]').val();
    var priority  = $('#myMXedit input[name=priority]').val();


    if(!check_domain(mailserver))
    {
     $('.error-edit-mailserver').html('<div class="alert alert-danger">Please enter a valid domain name. For example novaweb.vn</div>');
     return false; 
   }
   $('.error-edit-mailserver').html('');
   if(!$.isNumeric(priority))
   {
    $('.error-edit-priority').html('<div class="alert alert-danger">Priority must be a numeric</div>');
    return false; 
  }
  $('.error-edit-priority').html('');
                      //  $('.class-MX').val(priority+' '+mailserver);
                      $("form.update-record input[name=content]").val(priority+' '+mailserver);
                     // $("form.update-record .class_return").val(priority+' '+mailserver);
                     $( "#myMXedit .modal-footer .btn-default" ).trigger( "click" );

                       // return false;
                      //  alert('test');

  // do something...
})

  /*TXT record*/
  $('#myTXTedit .modal-footer .btn-primary').on('click', function () {
    var contenttxt  = $('#myTXTedit textarea[name=contenttxt]').val();

                        // alert(contenttxt); 
                        
                        if(contenttxt==null || contenttxt=='')
                        {
                         $('.error-edittxtcontent').html('<div class="alert alert-danger">Please fill out this field</div>');
                         return false; 
                       }
                       $('.error-edittxtcontent').html('');
                       $("form.update-record input[name=content]").val(contenttxt);
                       $( "#myTXTedit .modal-footer .btn-default" ).trigger( "click" );

                       // return false;
                      //  alert('test');

  // do something...
})
  /*spf record*/
  $('#mySPFedit .modal-footer .btn-primary').on('click', function () {
    var contentspf  = $('#mySPFedit textarea[name=contentspf]').val();

                        // alert(contenttxt); 
                        
                        if(contentspf==null || contentspf=='')
                        {
                         $('.error-editspfcontent').html('<div class="alert alert-danger">Please fill out this field</div>');
                         return false; 
                       }
                       $('.error-editspfcontent').html('');
                       $("form.update-record input[name=content]").val(contentspf);
                       $( "#mySPFedit .modal-footer .btn-default" ).trigger( "click" );

                       // return false;
                      //  alert('test');

  // do something...
})
//SRV record
$('#mySRVedit .modal-footer .btn-primary').on('click', function () {

  var srvpriority   = $('#mySRVedit input[name=srvpriority]').val();
  var srvweight     = $('#mySRVedit input[name=srvweight]').val();
  var srvport       = $('#mySRVedit input[name=srvport]').val();
  var srvtarget     = $('#mySRVedit input[name=srvtarget]').val();



                        // alert(contenttxt); 
                        


                        if(!$.isNumeric(srvpriority)||!$.isNumeric(srvweight)||!$.isNumeric(srvport))
                        {
                          $('.error-editsrvpriority').html('<div class="alert alert-danger">Priority, Weight, Port must be a numeric</div>');
                          return false; 
                        }
                        $('.error-editsrvpriority').html('');
                        if(srvtarget==null || srvtarget=='')
                        {
                         $('.error-editsrvpriority').html('<div class="alert alert-danger">Please fill out the Target field.</div>');
                         return false; 
                       }
                       $('.error-editsrvpriority').html('');
                       $("form.update-record input[name=content]").val(srvpriority+' '+srvweight+' '+srvport+' '+srvtarget);
                       $( "#mySRVedit .modal-footer .btn-default" ).trigger( "click" );

                       // return false;
                      //  alert('test');

  // do something...
})   
$('#myLOCedit .modal-footer .btn-primary').on('click', function () {
                        //alert('xxx');
                       //alert('xxx');
                       var latdegrees     =   $('#myLOCedit input[name=latdegrees]').val();
                       var latminutes     =   $('#myLOCedit input[name=latminutes]').val();
                       var latseconds     =   parseFloat($('#myLOC input[name=latseconds]').val());
                       var latdirection   =   $('#myLOCedit input[name=lat-direction-type]').val();
                       var longdirection  =   $('#myLOCedit input[name=long-direction-type]').val();

                       var longdegrees    =   $('#myLOCedit input[name=longdegrees]').val();
                       var longminutes    =   $('#myLOCedit input[name=longminutes]').val();
                       var longseconds    =   parseFloat($('#myLOCedit input[name=longseconds]').val());

                       var localtitude    =   parseFloat($('#myLOCedit input[name=localtitude]').val());   
                       var locsize        =   parseFloat($('#myLOCedit input[name=locsize]').val());

                       var lochorizontal  =   parseFloat($('#myLOCedit input[name=lochorizontal]').val());
                       var locvertical    =   parseFloat($('#myLOCedit input[name=locvertical]').val());      
                       if(!$.isNumeric(latdegrees)||!$.isNumeric(latminutes)||!$.isNumeric(latseconds))
                       {

                        $('.error-loclat').html('<div class="alert alert-danger">Degrees, Minutes, Seconds must be a numeric</div>');
                        return false; 
                      }
                      $('.error-loclat').html('');
                      if(!$.isNumeric(longdegrees)||!$.isNumeric(longminutes)||!$.isNumeric(longseconds))
                      {
                        $('.error-editloclong').html('<div class="alert alert-danger">Degrees, Minutes, Seconds must be a numeric</div>');
                        return false; 
                      }
                      $('.error-loclong').html('');
                      if(!$.isNumeric(localtitude)||!$.isNumeric(locsize))
                      {
                        $('.error-editlocaltitude').html('<div class="alert alert-danger">Altitude, Size must be a numeric</div>');
                        return false; 
                      }
                      $('.error-localtitude').html('');
                      if(!$.isNumeric(lochorizontal)||!$.isNumeric(locvertical))
                      {
                        $('.error-editlochorizontal').html('<div class="alert alert-danger">Altitude, Size must be a numeric</div>');
                        return false; 
                      }
                      $('.error-editlochorizontal').html('');


                      $("form.update-record input[name=content]").val(latdegrees+' '+latminutes+ ' '+latseconds.toFixed(3)+' '+latdirection+' '+longdegrees+' '+longminutes+ ' '+longseconds.toFixed(3)+' '+longdirection+ ' '+localtitude.toFixed(2)+'m'+ ' '+locsize.toFixed(2)+'m'+ ' '+lochorizontal.toFixed(2)+'m'+ ' '+locvertical.toFixed(2)+'m');
                      $( "#myLOCedit .modal-footer .btn-default" ).trigger( "click" );

                       // return false;
                      //  alert('test');

  // do something...
})


$("[data-mask]").inputmask();
$('#example1').DataTable({
  "paging": false,
  "lengthChange": false,
  "searching": true,
  "ordering": false,
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
/*click to edit*/

$('#example1').on('click','.edit-content',function(){
  $('form.update-record input[name=content]').tooltip('destroy'); 
  $(".form-update-record .need-remove-before").remove();
  $(".form-update-record").removeClass('none');
  $(".form-update-record").appendTo($(this).parent());
  $('input.input-edit-record').inputmask("remove");
  $('input.input-edit-record').removeAttr('data-target');//remove if is popup
      //var edit_type=$(this + 'a').
      $(this).find(".need-remove-before").clone().appendTo($(".form-update-record form"));
      var edit_type = $("form.update-record .type").val();

      if(edit_type=="LOC")
      {


        $('input.input-edit-record').attr('placeholder','Click to config');
        $('input.input-edit-record').attr('data-toggle','modal');
        $('input.input-edit-record').attr('data-target','#myLOCedit');
        $('input.input-edit-record').attr('data-backdrop','static');
        $('input.input-edit-record').attr('data-keyboard','false');
        var recordcontent=$("form.update-record .recordcontent").val();
        var result = recordcontent.split(' ');
        $('#myLOCedit input[name=latdegrees]').val(result[0]);
        $('#myLOCedit input[name=latminutes]').val(result[1]);
        $('#myLOCedit input[name=latseconds]').val(result[2]);

        if(result[3]=='N')
        {

          $('#myLOCedit .lat-direction-type-lable').html('North');

        }
        else
        {

         $('#myLOCedit .lat-direction-type-lable').html('South');
       }
       $('#myLOCedit .lat-direction-type-value').html(result[3]);

       $('#myLOCedit input[name=longdegrees]').val(result[4]);
       $('#myLOCedit input[name=longminutes]').val(result[5]);
       $('#myLOCedit input[name=longseconds]').val(result[6]);

       if(result[7]=='W')
       {

        $('#myLOCedit .long-direction-type-lable').html('West');

      }
      else
      {

       $('#myLOCedit .long-direction-type-lable').html('East');
     }
     $('#myLOCedit .long-direction-type-value').html(result[7]);

     var localtitude   = result[8].split('m');
     $('#myLOCedit input[name=localtitude]').val(localtitude[0]);

     var locsize   = result[9].split('m');
     $('#myLOCedit input[name=locsize]').val(locsize[0]);

     var lochorizontal   = result[10].split('m');
     $('#myLOCedit input[name=lochorizontal]').val(lochorizontal[0]);

     var locvertical   = result[11].split('m');

     $('#myLOCedit input[name=locvertical]').val(locvertical[0]);

   }
   else if(edit_type=='MX')
   {
    $('input.input-edit-record').attr('placeholder','Click to config');
    $('input.input-edit-record').attr('data-toggle','modal');
    $('input.input-edit-record').attr('data-target','#myMXedit');
    $('input.input-edit-record').attr('data-backdrop','static');
    $('input.input-edit-record').attr('data-keyboard','false');
    var recordcontent=$("form.update-record .recordcontent").val();

    var result = recordcontent.split(' ');

    $('#myMXedit input[name=mailserver]').val(result[1]);
    $('#myMXedit input[name=priority]').val(result[0]);
            //alert(result[0]);
           // alert(result[1]);

            //alert( result[2] );
            //alert($(this).text());
          }
          else if(edit_type=='SRV')
          {
            $('input.input-edit-record').attr('placeholder','Click to config');
            $('input.input-edit-record').attr('data-toggle','modal');
            $('input.input-edit-record').attr('data-target','#mySRVedit');
            $('input.input-edit-record').attr('data-backdrop','static');
            $('input.input-edit-record').attr('data-keyboard','false');
            var recordcontent=$("form.update-record .recordcontent").val();
            
            var result = recordcontent.split(' ');
            
            $('#mySRVedit input[name=srvpriority]').val(result[0]);
            $('#mySRVedit input[name=srvweight]').val(result[1]);
            $('#mySRVedit input[name=srvport]').val(result[2]);
            $('#mySRVedit input[name=srvtarget]').val(result[3]);

            //alert(result[0]);
           // alert(result[1]);

            //alert( result[2] );
            //alert($(this).text());
          }

          else if(edit_type=='TXT')
          {
            $('input.input-edit-record').attr('placeholder','Click to config');
            $('input.input-edit-record').attr('data-toggle','modal');
            $('input.input-edit-record').attr('data-target','#myTXTedit');
            $('input.input-edit-record').attr('data-backdrop','static');
            $('input.input-edit-record').attr('data-keyboard','false');
            var contenttxt=$("form.update-record .recordcontent").val();   
            $('#myTXTedit textarea[name=contenttxt]').val(contenttxt);

            //alert(result[0]);
           // alert(result[1]);

            //alert( result[2] );
            //alert($(this).text());
          }
        //SPF record
        else if(edit_type=='SPF')
        {
          $('input.input-edit-record').attr('placeholder','Click to config');
          $('input.input-edit-record').attr('data-toggle','modal');
          $('input.input-edit-record').attr('data-target','#mySPFedit');
          $('input.input-edit-record').attr('data-backdrop','static');
          $('input.input-edit-record').attr('data-keyboard','false');
          var contentspf=$("form.update-record .recordcontent").val();   
          $('#mySPFedit textarea[name=contentspf]').val(contentspf);

            //alert(result[0]);
           // alert(result[1]);

            //alert( result[2] );
            //alert($(this).text());
          }
          else if(edit_type=='A')
          {
           $('input.input-edit-record').attr('placeholder','IPv4 Address');
          // $('input.input-edit-record').attr('data-inputmask',"'alias': 'ip'");
          // $('input.input-edit-record').attr('data-mask','123');
$('input.input-edit-record').inputmask("ip");


        }
        else if(edit_type=='AAAA')
        {
         $('input.input-edit-record').attr('placeholder','IPv6 Address');
          // $('input.input-edit-record').attr('data-inputmask',"'alias': 'ip'");
          // $('input.input-edit-record').attr('data-mask','123');
//$('input.input-edit-record').inputmask("ipv6");


        }
        else
        {
          $('input.input-edit-record').attr('placeholder','name');
          $('input.input-edit-record').removeAttr('data-toggle','modal');
          $('input.input-edit-record').removeAttr('data-target','#myMXedit');
          $('input.input-edit-record').removeAttr('data-backdrop','static');
          $('input.input-edit-record').removeAttr('data-keyboard','false'); 
        }
      })

$('#example1').on('click','.button-update-record',function(){
  var ajax_url_edit= $('form.update-record').attr('action');
  
  var edit_id=domain_id;
  var edit_token =$("form.update-record input[name=_token]").val();
  var edit_record_name = $("form.update-record .record-name").val();
  var edit_ttl = $("form.update-record .ttl").val();
  var edit_type = $("form.update-record .type").val();
  var edit_input_content=$("form.update-record input[name=content]").val();
  if(edit_input_content==null||edit_input_content=='')
  {
    $('form.update-record input[name=content]').tooltip({ 
    placement: "top",
    title:'This field is required',
    trigger:'click',
  });  
  $('form.update-record input[name=content]').tooltip('show');
  return false;
  }
  


  var class_return = $("form.update-record .class_return").val();
  $('.box-update-record .button-update-record').append('<span class="loading-for-waiting"></span>');
  $('.box-update-record .button-update-record').removeClass('btn-info');
  $.post(ajax_url_edit,{name:edit_record_name,content:edit_input_content,id:edit_id,_token:edit_token,type:edit_type,ttl:edit_ttl}).done(function(rdata){
    $('.box-update-record .loading-for-waiting').remove();
    $('.box-update-record .button-update-record').addClass('btn-info');
    var response=$.parseJSON(rdata);

    if(response.error_status==1)
    {
      alert(response.error);    
    }
    else/*if add record successful*/
    {
      $('#'+class_return+' .show-content').html(response.data.content);
                            ////return hidden record after click 
                            $("form.update-record input[name=content]").val('');
                            $(".form-update-record").addClass('none');
                          }
                        //  domain-error-msg//
                        return false;
                      })
  return false;

    // $(this + ' .need-remove-before').appendTo($(".form-update-record form"));

  })



$('#example1').on('click','.click-to-delete',function(){
  var delete_type     = $(this).attr('type');
  var delete_name     = $(this).attr('name');
  var delete_content  = $(this).attr('content');
  var delete_id       = $(this).attr('deleteid');
  var delete_ttl      = $(this).attr('ttl');
  var delete_token    =  $('meta[name="_token"]').attr('content');
  var ajax_url_delete = admin_url +"/account/domain/delete_record";
  var divdelete      = $(this).attr('divdelete');
      //alert(divdelete);
      if (confirm( "Are you sure to continue" ))
      {
        //return true;
      }
      else
      {
        return false;
      } 
      $.post(ajax_url_delete,{name:delete_name,content:delete_content,id:delete_id,_token:delete_token,type:delete_type,ttl:delete_ttl},function(ddata){
       var response=$.parseJSON(ddata);
       if(response.error_status==1)
       {
        alert(response.error);

      }
      else{
          //alert('texx');
       // $('#'+divdelete).addClass('none');
       $('#'+divdelete).hide('slow');
     }                 
     return false;
   });

    })
});