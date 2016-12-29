/*created by Ha Ngo*/
function check_domain(v)
{
	return /^[a-zA-Z0-9-][a-zA-Z0-9--.]{1,61}[a-zA-Z0-9]\.[a-zA-Z]{2,5}$/.test(v);
}
function check_ip(v)
{
	if (/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(v))  
  {  
    return true;
  } 
  else
  {
  	return false;
  } 

}

function checkipv6(str)
{
	var perlipv6regex = "^\s*((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:)))(%.+)?\s*$";
	var aeronipv6regex = "^\s*((?=.*::.*)(::)?([0-9A-F]{1,4}(:(?=[0-9A-F])|(?!\2)(?!\5)(::)|\z)){0,7}|((?=.*::.*)(::)?([0-9A-F]{1,4}(:(?=[0-9A-F])|(?!\7)(?!\10)(::))){0,5}|([0-9A-F]{1,4}:){6})((25[0-5]|(2[0-4]|1[0-9]|[1-9]?)[0-9])(\.(?=.)|\z)){4}|([0-9A-F]{1,4}:){7}[0-9A-F]{1,4})\s*$";

	var regex = "/"+perlipv6regex+"/";
	return (/^\s*((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:)))(%.+)?\s*$/.test(str));
}
function show_hide_popup(ip)
{
 // alert(ip);
  if(check_ip(ip))
  {
     $('.check-ip-address-4').tooltip('destroy');
    // alert('xx');
  }
}
function check_empty(str)
{

  if(str.length>0)
  {
   // alert(str.length);
    $('.record-name').tooltip('destroy');
  }
}
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

//auto complete
 
   $( function() {
     $( "input.user-assign" ).keydown(function() {
  //alert( "Handler for .keydown() called." );
  $(this).tooltip('destroy'); 
});
    $( "input.user-assign" ).autocomplete({

      source: function( request, response ) {
        $.ajax( {
          url: admin_url+"/synchronize/autocomplete?callback=&q="+request.term,
          dataType: "json",
          success: function( data ) {
            response( $.map( data, function( item ) {
    return {
        label: item,
        value: item
    }
}));
          }
        } );
      },minLength: 3,    

    });
    $('.button-sync-to-local').click(function(){
        //alert($(this).attr('rel'));
        var _token=$('meta[name="_token"]').attr('content');
        var class_rel=$(this).attr('rel');
        var the_value=$('.domain-listed-on-server-'+class_rel+' .user-assign').val();
        var domain=$('.domain-listed-on-server-'+class_rel+' .domain').val();
        if(the_value==''||!validateEmail(the_value))
        {

         $('.domain-listed-on-server-'+class_rel+' .user-assign').tooltip({ 
    placement: "top",
    title:'This field is required',
    trigger:'click',
  });  
  $('.domain-listed-on-server-'+class_rel+' .user-assign').tooltip('show');   
        }
        else{
            $.post(admin_url+'/synchronize/synctolocal',{email:the_value,domain:domain,_token:_token},function(data){
                if(data==1)
                {
                    $('.domain-listed-on-server-'+class_rel).remove();
                    
                }
                else{
                    $('.domain-listed-on-server-'+class_rel+' .user-assign').tooltip({ 
                    placement: "top",
                    title:'Could not synchronize this domain to local',
                    trigger:'click',
                  });  
                  $('.domain-listed-on-server-'+class_rel+' .user-assign').tooltip('show');  
                }
            })
        }

    })
    //sync to server
    $('.button-sync-to-server').click(function(){
        //alert($(this).attr('rel'));
        var _token=$('meta[name="_token"]').attr('content');
        var class_rel=$(this).attr('rel');
        
        var domain=$('.domain-listed-on-local-'+class_rel+' .domain').val();
        
        
            $.post(admin_url+'/account/domain/add',{domain:domain,_token:_token},function(data){
                
                    $('.domain-listed-on-local-'+class_rel).remove();
                             
            })
       

    })
    //end sync to server 

    $('.button-remove-from-local').click(function(){
        //alert($(this).attr('rel'));
        var _token=$('meta[name="_token"]').attr('content');
        var class_rel=$(this).attr('rel');
        
        var domain=$('.domain-listed-on-local-'+class_rel+' .domain').val();
        
        if ( confirm("Are you sure to continue?") )
        {

           $.post(admin_url+'/synchronize/delete',{domain:domain,_token:_token},function(data){
                
                    $('.domain-listed-on-local-'+class_rel).remove();
                             
            })  
        }
        else
        {
            //ht[0].style.filter = "";
            return false;
        }
           
       

    })

  } );
function confirmdelete(theurl)
{
  if ( confirm("Are you sure to continue?") )
        {

          window.location=theurl;
        }
        else
        {
            //ht[0].style.filter = "";
            return false;
        }
}
