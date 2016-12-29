<?php
namespace App\Http\Controllers\Account;
use Illuminate\Http\Request;
use App\Domains;
use App\Logs;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use DateTime;
class DomainsController extends Controller
{
  public function __construct() {
    $settings   =   DB::table('settings')->where('key','apiaccess')->first();
    if(!is_object($settings))
    {
      exit('Please config API access to connect server');
    }
    $api=unserialize($settings->value);
    $this->hostmaster              = $api['hostmaster']['value'];
    $this->hostmaster_record_soa   = $api['hostmaster_record_soa']['value'];
    $this->port                    = $api['api_port']['value'];
    $this->auth                    = $api['api_key']['value'];
    $this->path                    = $api['zonepath']['value'];
    $this->proto                   = $api['api_protocol']['value'];
    $this->sslverify               = $api['api_sslverify']['value'];
    $this->ns1                     = $api['ns1']['value'];
    $this->ns2                     = $api['ns2']['value'];
    $this->text                    = '28800 7200 604800 86400';
        $this->ttl                     = Auth::user()->ttl?Auth::user()->ttl:3600;//
      }

      public function index()
      {
        return view('pages.account.index');	

      }
      public function domains()
      {
        $user = Auth::user();
        $user_id = intval($user->id);
        $allow=get_permission($user->is_root,$user->permission,'account_domains');
        if($allow)//check if it is admin
        {
         $domains = DB::table('domains')->paginate(20);
       }
       else
       {
         $domains = DB::table('domains')->where([
          ['user_id','=',$user_id]
          ])->paginate(20); 
       }
       return view('pages.account.domain')->with(['domains'=>$domains]);
     }
     public function add_domain(Request $request)
     {
      $ns1              = $this->ns1;
      $ns2              = $this->ns2;
      $hostmaster       = $this->hostmaster;
      $text             = $this->text;
      $ttl              = $this->ttl;
      $domain=$request->input('domain');
      $result['error']='';
      if(!$this->validDomain($domain))
      {
        $result['error']='Please enter a valid domain name. For example novaweb.vn';	
      }
      else
      {
        $array=array(
          'name'			=>$domain.'.',
          'kind'			=>'Master',
          'masters'		=>'[]',
          'nameservers' =>array(),
          );
        $result=json_decode($this->connectserver($array),true);
        if(!isset($result['error'])):
        // update server
          $array=array(
            'name'      =>$domain.'.',
            'ttl'      =>$this->ttl,
            'type'   =>'SOA',
            'changetype' =>array('ns1.novaweb.vn.','ns2.novaweb.vn.'),
          //'nameservers' =>array($this->ns1.'.',$this->ns2.'.'),
            );
        $rrsets=$result['rrsets'][0]['records'][0]['content'];
        $rrsets=explode(' ',$rrsets);
        $rrsets_tmp='';
        foreach($rrsets as $k=>$v):
          if($k==0)
          {
            $v=$ns1.'.';
          }
          if($k==1)
          {
            $v=$this->hostmaster_record_soa.'.';
          }  
          $rrsets_tmp .=$v.' ';
          endforeach;
          $rrsets=$rrsets_tmp;
          $array='{"rrsets": [ {"name": "'.$domain.'.", "type": "SOA", "changetype": "REPLACE", "records": [ {"content": "ns1.artemit.local hostmaster.artemit.com.es 2016102601 10800 3600 604800 3600", "disabled": false, "name":  "'.$domain.'.", "ttl": 86400, "type": "SOA", "priority": 0 } ] } ] }';
          $array='{"rrsets": [
          {"name":  "'.$domain.'.",
          "type": "SOA",
          "ttl": 86400,
          "changetype": "REPLACE",
          "records": [ {"content": "'.trim($rrsets).'", "disabled": false} ]
        }]}';
        $this->connectserver_add_record($array,$domain.'.');
        $user = Auth::user();
        $now = new DateTime();
        $domains = new Domains;
        $domains->name = $domain;
        $domains->type = 0;
        $domains->user_id =  $user->id;  
        $domains->master =	'master';
        $domains->created_at =	$now;
        $domains->updated_at =	$now;
        $domains->save();
        $xdata 	=	DB::table('domains')->where('user_id',$user->id)->orderBy('id','DESC')->first();
        $data['id']=$xdata->id;
        $data['name']=$xdata->name;
        $data['master']=$xdata->master;
        $data['type']='Free website';
        $data['created_at']=$xdata->created_at;
        $data['updated_at']=$xdata->updated_at;
        $result['data']=$data;
        $logs   = new Logs;
        $log_content            =   array(
          'action'=>'Add',
          'domain'=>$domain,
          'title'     =>'Add new domain',
          'record'=>array(
            'name'      =>$domain,
            'type'      =>'SOA',
            'content'   =>$rrsets,
            'ttl'       =>$ttl,
            ),
          'comment'       =>'',
          );
        $logs->domain_id        =   $xdata->id;
        $logs->domain           =   $xdata->name;
        $logs->user_id          =   $user->id;
        $logs->action           =   'add';
        $logs->content          =   serialize($log_content);
        $logs->created_at       =   $now;
        $logs->updated_at       =   $now;
        $logs->save();
        endif;
      }
      echo json_encode($result);exit;
    }
    public function count_record($id)
    {
      return 1;
      $records_count=DB::select("select count(id) as count from records where domain_id ='{$id}'"); 
      return $records_count[0]->count;
    }
    function edit(Request $request,$id)
    {
     $id=intval($id);
     $msg_maximum='';
     $user = Auth::user();
     $user_id  = intval($user->id);
     $allow=$this->checkowner($id,'account_domain_edit');
     if($allow)
     {
      /*if($this->count_record($id)>=15)
      {
        $msg_maximum='You are using your maximum allotment (15) of domain records. If you want more, contact your service provider.';
      }*/
      $domains 				=	DB::table('domains')->where('id',$id)->first();
      $api 					=	json_decode($this->connectserver_get($domains->name));
      if(!is_object($api))
      {
        return Redirect::to('/account/apiaccess');
      }
      if(!isset($api->rrsets))
      {
        return Redirect::to('/account/apiaccess');
      }
      $session_record=array();
      if(is_array($api->rrsets))
      {
        foreach ($api->rrsets as $key => $value) {
          $session_record[]=array(
            'name'=>$value->name,
            'content'=>$value->records[0]->content,
            'ttl'=>$value->ttl,
            'type'=>$value->type,

            );
        }
      }
      Session::put('records', $session_record);
      Session::save();
      $domains->api_kind		=	$api->kind;
      $domains->api_name		=	$api->name;
      $domains->api_content 	=	$api->rrsets[0]->records[0]->content;
      $domains->api_ttl		=	$api->rrsets[0]->ttl;
      $domains->api_type		=	$api->rrsets[0]->type;
      $domains->api_serial	=	$api->serial;
      usort($api->rrsets, array($this, "cmp"));
      $domains->rrsets        =   $api->rrsets;

      $records='';
      foreach ($domains->rrsets as $rrsets):
       if($rrsets->type=='SOA')
       {
        $records=$rrsets;
      }
      endforeach;
      $ttl_user=Auth::user()->ttl;
      switch($ttl_user) {
        case '120':   
        $ttl_text='2 minutes';
        break;
        case '300':   
        $ttl_text='5 minutes';
        break;
        case '600':   
        $ttl_text='10 minutes';
        break;
        case '900':   
        $ttl_text='15 minutes';
        break;
        case '1800':   
        $ttl_text='30 minutes';
        break;
        case '3600':   
        $ttl_text='1 hour';
        break;
        case '7200':   
        $ttl_text='2 hours';
        break;
        case '18000':   
        $ttl_text='5 hours';
        break;
        case '43200':   
        $ttl_text='12 hours';
        break;
        case '86400':   
        $ttl_text='1 day';
        break;
        default:
        $ttl_text='2 minutes';
      }
      return view('pages.account.domain_edit')->with(['domains'=>$domains,'msg_maximum'=>$msg_maximum,'records'=>$records,'ttl_text'=>$ttl_text]);
    }
    else
    {
      Session::flash('global-error-message', 'Something went wrong'); 
      return Redirect::to('/account/domains');
    }
  }
  public function cmp($a, $b)
  {
    return strcmp($a->type, $b->type);
  }
//add record
  public function update_record(Request $request)
  {
   $type = $request->input('type');
   $id = intval($request->input('id'));
   $content = $request->input('content');
   $name = $request->input('name');
   $ttl = $request->input('ttl');
   $msg='';
    $dot='';//need add dot to the content
    $before='';
    if(!$content)
    {
      $msg='Please fill out all the fileds.';
      $data['error']=$msg;
      $data['content']='';
      $data['error_status']=1;
      echo json_encode($data);exit; 
    }
    if(!$this ->checkowner($id,'account_record_edit'))
    {
      $msg="You don't have permission to edit record on this domain";
      $data['error']=$msg;
      $data['content']='';
      $data['error_status']=1;
      echo json_encode($data);exit;

    }
    $domains                =   DB::table('domains')->where('id',$id)->first();
    $error=0;
	//review code before submited to server
    switch ($type) {
      case 'A':
      if(!$this->is_valid_ipv4($content))
      {
       $error=1;
       $msg='This is not a valid IPv4 address';
     }
     break;
     case 'AAAA':
     if(!$this->is_valid_ipv6($content))
     {
       $error=1;
       $msg='This is not a valid IPv6 address';
     }
     break;
     case 'CNAME':
     $dot='.';
     break;
     case 'NS':
     if(!$this->validDomain($content))
     {
      $msg='Please enter a valid Name Server . For example novaweb.vn'; 
      $error=1;   
    }
    $dot='.';
    break;        
    case 'MX':
    $dot='.';
    break; 
    case 'SRV':
    $dot='.';
    break;           
    default:
    $error=0;
  }
  $data['error']=$msg;
  $data['content']='';
  $data['error_status']=0;
  if($error==1)
  {
    $data['error_status']=1;
    echo json_encode($data);
    exit;
  }
  else
  {
    $continue=1;
    
    if($type=='SPF'||$type=='TXT')
    {
      $array='{"rrsets": [
      {"name": "'.$name.'.",
      "type": "'.$type.'",
      "ttl": '.$ttl.',
      "changetype": "REPLACE",
      "records": [ {"content": "\"'.$before.$content.$dot.'\"", "disabled": false,"ttl": '.$ttl.',"name": "'.$name.'.","priority": 0,"type": "'.$type.'"} ]}] }';   
    }
    else
    {
      $array='{"rrsets": [
      {"name": "'.$name.'.",
      "type": "'.$type.'",
      "ttl": '.$ttl.',
      "changetype": "REPLACE",
      "records": [ {"content": "'.$before.$content.$dot.'", "disabled": false,"ttl": '.$ttl.',"name": "'.$name.'.","priority": 0,"type": "'.$type.'"} ]}] }';  
    }

    $result=$this->connectserver_add_record($array,$domains->name.'.');
    $now = new DateTime();
    if(!$result)
    {
      $user = Auth::user();
      $user_id = intval($user->id);
      $msg='You have been added a new record';
      $data['error']=$msg;
      $data['data']=array(
        'name'=>$name ,
        'content'=>$content ,
        'type'=>$type ,
        'ttl'=>$ttl ,
        );
      $data['error_status']=0;
      $logs   = new Logs;
      $log_content            =   array(
        'action'=>'Update',
        'domain'=>$domains->name,
        'title'     =>'Update record domain',
        'record'=>array(
          'name'      =>$name,
          'type'      =>$type,
          'content'    =>$content ,
          'ttl'=>$ttl ,
          ),
        'comment'       =>'',
        );
      $logs->domain_id        =   $domains->id;
      $logs->domain           =   $domains->name;
      $logs->user_id          =   $user->id;
      $logs->action           =   'update';
      $logs->content          =   serialize($log_content);
      $logs->ip               =   $_SERVER['SERVER_ADDR'];
      $logs->created_at       =   $now;
      $logs->updated_at       =   $now;
      $logs->save();
    //save session
      $domains         = DB::table('domains')->where('id',$domains->id)->first();
      $api          = json_decode($this->connectserver_get($domains->name));
      $session_record=array();
      if(is_array($api->rrsets))
      {
        foreach ($api->rrsets as $key => $value) {
                //echo "<pre>";print_r($value);exit;
          $session_record[]=array(
            'name'=>$value->name,
            'content'=>$value->records[0]->content,
            'ttl'=>$value->ttl,
            'type'=>$value->type,
            );
        }
      }
           // echo "<pre>";print_r($session_record);exit;
      Session::put('records', $session_record);
      Session::save();
             //end save session
      echo json_encode($data);exit;
    }
    else
    {
      $msg=$result;
      $data['error']=$msg;
      $data['data']='';
      $data['error_status']=1;
      echo json_encode($data);exit;
    }
  }
}
public function add_record(Request $request)
{
  $type = $request->input('type');
  $id = intval($request->input('id'));
  $content = $request->input('content');
  $name = $request->input('name');
  $ttl = $request->input('ttl');
  $msg='';
  $dot='';//need add dot to the content
  $before='';
  if(!$content)
  {
    $msg='Please fill out all the fileds.';
    $data['error']=$msg;
    $data['content']='';
    $data['error_status']=1;
    echo json_encode($data);exit; 
  }
  if(!$this->checkowner($id,'account_record_add'))
  {
    $msg="You don't have permission to add new record on this domain";
    $data['error']=$msg;
    $data['content']='';
    $data['error_status']=1;
    echo json_encode($data);exit;
  }
  if($this->count_record($id)>=15)
  {
    $msg='You are using your maximum allotment (15) of domain records. If you want more, contact your service provider.';
    $data['error']=$msg;
    $data['content']='';
    $data['error_status']=1;
    echo json_encode($data);exit;
  }
  $domains                =   DB::table('domains')->where('id',$id)->first();
  $error=0;
    //review code before submited to server
  switch ($type) {
    case 'A':
    if(!$this->is_valid_ipv4($content))
    {
      $error=1;
      $msg='This is not a valid IPv4 address';
    }
    break;
    case 'AAAA':
    if(!$this->is_valid_ipv6($content))
    {
      $error=1;
      $msg='This is not a valid IPv6 address';
    }
    break;
    case 'CNAME':
    $dot='.';
    $is_valid_hostname_fqdn =   $this->is_valid_hostname_fqdn($content,0);
    if(is_array($is_valid_hostname_fqdn))
    {
      $error=1;
      $msg=$is_valid_hostname_fqdn['msg'];
    }   
    break;  
    case 'NS':
    if(!$this->validDomain($content))
    {
      $msg='Please enter a valid Name Server . For example novaweb.vn'; 
      $error=1;   
    }
    $dot='.';
    break;      
    case 'MX':
    $dot='.';
    break;
    case 'SRV':
    $dot='.';
    break;
    default:
    $error=0;
  }
  $data['error']=$msg;
  $data['content']='';
  $data['error_status']=0;
  if($error==1)
  {
    $data['error_status']=1;
    echo json_encode($data);
    exit;
  }
  else
  {
    $continue=1; 
    if($name==strtolower('@'))
    {
      $name=$domains->name;
    }
    elseif($type=='SRV')
    {
      $name=$name;  
    }
    else{
      $name=$name.'.'.$domains->name;   
    }
    if($type=='SPF'||$type=='TXT')
    {
      $content= '\"'.$before.$content.$dot.'\"';
    }
    else
    {
      $content=$before.$content.$dot;
    }
    if($this->check_duplicated_record($name.'.',$content,$type))
    {
      $msg='There is already exists an A, AAAA,MX,NS,SPF,LOC or CNAME with this name';
      $data['error']=$msg;
      $data['data']='';
      $data['error_status']=1;
      echo json_encode($data);exit;
    }
    $array='{"rrsets": [
    {"name": "'.$name.'.",
    "type": "'.$type.'",
    "ttl": '.$ttl.',
    "changetype": "REPLACE",
    "records": [ {"content": "'.$content.'", "disabled": false,"ttl": '.$ttl.',"name": "'.$name.'.","priority": 0,"type": "'.$type.'"} ]}] }';
    $result=$this->connectserver_add_record($array,$domains->name.'.');
    $now = new DateTime();
    if(!$result)
    {
      $user = Auth::user();
      $user_id = intval($user->id);  
      $msg='You have been added a new record';
      $data['error']=$msg;
      $data['data']=array(
        'name'=>$name ,
        'content'=>$content ,
        'type'=>$type ,
        'ttl'=>$ttl ,
        'divid'=>str_replace('.','-',trim($name,'.')),
        );
      $data['error_status']=0;
        //addl logs
      $logs   = new Logs;
      $log_content            =   array(
        'action'=>'Add',
        'domain'=>$domains->name,
        'title'     =>'Add a new record',

        'record'=>array(
          'name'      =>$name,
          'type'      =>$type,
          'content'    =>$content ,
          'ttl'=>$ttl ,
          ),
        'comment'       =>'',
        );
      $logs->domain_id        =   $domains->id;
      $logs->domain           =   $domains->name;
      $logs->user_id          =   $user->id;
      $logs->action           =   'add';
      $logs->content          =   serialize($log_content);
      $logs->ip               =   $_SERVER['SERVER_ADDR'];
      $logs->created_at       =   $now;
      $logs->updated_at       =   $now;
      $logs->save();
            //save session
      $domains         = DB::table('domains')->where('id',$domains->id)->first();
      $api          = json_decode($this->connectserver_get($domains->name));
      $session_record=array();
      if(is_array($api->rrsets))
      {
        foreach ($api->rrsets as $key => $value) {
          $session_record[]=array(
            'name'=>$value->name,
            'content'=>$value->records[0]->content,
            'ttl'=>$value->ttl,
            'type'=>$value->type,

            );
        }
      }
      Session::put('records', $session_record);
      Session::save();
        //end save session
      echo json_encode($data);exit;
    }
    else
    {
      $msg=$result;
      $data['error']=$msg;
      $data['data']='';
      $data['error_status']=1;
      echo json_encode($data);exit;
    }
  }
}
/*Delete domain*/
public function delete_domain(Request $request,$id)
{
  $user = Auth::user();
  $user_id = intval($user->id);
  $id = intval($id);
  $domain                =   DB::table('domains')->where('id',$id)->first();  
  $allow=$this->checkowner($id,'domain_delete');
     if(!$allow)//check if it is admin
     {
      exit("You don't have permission to delete this domain");
    }
    $result=$this->connectserver_delete_domain($domain->name.'.');
    if($result=='')
    {
      $delete=new Domains;
      $delete=$delete->Find($id);
      $delete->delete();
      return redirect('account/domains')->with('success','Domain '.$domain->name.' successfully deleted');  
    }
    else
    {
      return redirect('account/domains')->with('error','Could not delete domain '.$domain->name);
    }
    exit();
  }

public function delete_record(Request $request)//delete record
{
  $type = $request->input('type');
  $id = intval($request->input('id'));
  $content = $request->input('content');
  $name = $request->input('name');
  $ttl = $request->input('ttl');
  $msg='';
    $dot='';//need add dot to the content
    $before='';
    $error=0;
    if(!$this ->checkowner($id,'account_record_delete'))
    {
      $msg="You don't have permission to delete record on this domain";
      $data['error']=$msg;
      $data['content']='';
      $data['error_status']=1;
      echo json_encode($data);
      exit;
        //exit('You are not owner this domain');
    }
    $domains                =   DB::table('domains')->where('id',$id)->first();
    //review code before submited to server
    switch ($type) {
      case 'A':
      if(!$this->is_valid_ipv4($content))
      {
        $error=1;
        $msg='This is not a valid IPv4 address';
      }
      break;
      case 'AAAA':
      if(!$this->is_valid_ipv6($content))
      {
        $error=1;
        $msg='This is not a valid IPv6 address';
      }
      break;
      case 'CNAME':
      $dot='.';
      break;   
      case 'MX':
      $dot='.';
      $before='10 ';
      break;        
      default:
      $error=0;
    }
    $data['error']=$msg;
    $data['content']='';
    $data['error_status']=0;
    if($error=0)
    {
      $data['error_status']=1;
      echo json_encode($data);
      exit;
    }
    else
    {
      $continue=1;
      $array='{"rrsets": [
      {"name": "'.$name.'",
      "type": "'.$type.'",
      "ttl": '.$ttl.',
      "changetype": "DELETE",
      "records": [ {"content": "'.$content.'", "disabled": false,"ttl": '.$ttl.',"name": "'.$name.'.","priority": 0,"type": "'.$type.'"} ]}] }';
      $result=$this->connectserver_add_record($array,$domains->name.'.');
      $now = new DateTime();
      if(!$result)
      {
        $this->remove_record($name,$type);
        $user = Auth::user();
        $user_id = intval($user->id);
        $msg='You have been removed a new record';
        $data['error']=$msg;
        $data['data']=array(
          'name'=>$name ,
          'content'=>$content ,
          'type'=>$type ,
          'ttl'=>$ttl ,
          'divid'=>str_replace('.','-',trim($name,'.')),
          );
        $data['error_status']=0;
        //add logs
        $logs   = new Logs;
        $log_content            =   array(
          'action'=>'Delete',
          'domain'=>$domains->name,
          'title'     =>'Delete a record',
          'record'=>array(
            'name'      =>$name,
            'type'      =>$type,
            'content'    =>$content ,
            'ttl'=>$ttl ,
            ),
          'comment'       =>'',
          );
        $logs->domain_id        =   $domains->id;
        $logs->domain           =   $domains->name;
        $logs->user_id          =   $user->id;
        $logs->action           =   'delete';
        $logs->content          =   serialize($log_content);
        $logs->ip               =   $_SERVER['SERVER_ADDR'];
        $logs->created_at       =   $now;
        $logs->updated_at       =   $now;
        $logs->save();
        echo json_encode($data);exit;
      }
      else
      {
        $msg=$result;
        $data['error']=$msg;
        $data['data']='';
        $data['error_status']=1;
        echo json_encode($data);exit;
      }
    }
  }

	//check valid function
  public function validDomain($domain) {
    if(preg_match('/([a-zA-Z0-9\-_]+\.)?[a-zA-Z0-9\-_]+\.[a-zA-Z]{2,5}/',$domain))
    {
     return true;
   }
   else
   {
     return false;   
   }
 }
//API connect to server
 public function connectserver_delete_domain($domain='')
 {
  $api_key=$this->auth;
  $api_server=$this->proto.'://'.$this->hostmaster.':'.$this->port.'/'.$this->path.'/'.$domain;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $api_server);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
  $headers = array();
  $headers[] = "X-Api-Key: $api_key";
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  $result = curl_exec($ch);
  curl_close ($ch);
  return $result;
}

public function connectserver($array=array(),$domain='')
{
  $json=json_encode($array);	
  $api_key=$this->auth;
  $api_server=$this->proto.'://'.$this->hostmaster.':'.$this->port.'/'.$this->path.$domain;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $api_server);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS,$json);
  curl_setopt($ch, CURLOPT_POST, 1);
  $headers = array();
  $headers[] = "X-Api-Key: $api_key";
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  $result = curl_exec($ch);
  curl_close ($ch);
  return $result;
}
public function connectserver_add_record($data,$domain='',$method='PATCH')
{
  $api_key=$this->auth;
  $api_server=$this->proto.'://'.$this->hostmaster.':'.$this->port.'/'.$this->path.'/'.$domain;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $api_server);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
  $headers = array();
  $headers[] = "X-Api-Key: $api_key";
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  $result = curl_exec($ch);
  curl_close ($ch);
  return $result;
}
public function connectserver_get($domain='')
{
  $api_key=$this->auth;
  $api_server=$this->proto.'://'.$this->hostmaster.':'.$this->port.'/'.$this->path.'/'.$domain;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $api_server);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
  $headers = array();
  $headers[] = "X-Api-Key: $api_key";
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  $result = curl_exec($ch);
  curl_close ($ch);
  return $result;
}

public function checkowner($id,$check='')
{
  $user = Auth::user();
  $user_id = intval($user->id);
  $group_id=intval($user->group_id);
  $allow=get_permission($user->is_root,$user->permission,$check);
  if($allow)
  {
    return $allow;
  }
  $domains 	=	DB::table('domains')->where([
    ['id',$id],
    ['user_id',$user_id]
    ])->first();
  if(!is_object($domains))
  {
    return false;
  }
  else
  {
    return true;
  }
}

public function is_valid_hostname_fqdn($hostname, $wildcard) {

  $hostname = preg_replace("/\.$/", "", $hostname);

    # The full domain name may not exceed a total length of 253 characters.
  if (strlen($hostname) > 253) {
        //error(ERR_DNS_HN_TOO_LONG);
   $msg='the hostname is too long.';
   $true=0;
   $result['msg']=$msg;
   $result['true']=$true;
   return $result;
 }

 $hostname_labels = explode('.', $hostname);
 $label_count = count($hostname_labels);



 foreach ($hostname_labels as $hostname_label) {
  if ($wildcard == 1 && !isset($first)) {
    if (!preg_match('/^(\*|[\w-\/]+)$/', $hostname_label)) {
               // error(ERR_DNS_HN_INV_CHARS);
      $msg='You have invalid characters in your hostname.';
      $true=0;
      $result['msg']=$msg;
      $result['true']=$true;
      return $result;

    }
    $first = 1;
  } else {
    if (!preg_match('/^[\w-\/]+$/', $hostname_label)) {
     $msg='You have invalid characters in your hostname.';
     $true=0;
     $result['msg']=$msg;
     $result['true']=$true;
     return $result;
   }
 }
 if (substr($hostname_label, 0, 1) == "-") {
            //error(ERR_DNS_HN_DASH);
   $msg='A hostname can not start or end with a dash.';
   $true=0;
   $result['msg']=$msg;
   $result['true']=$true;
   return $result;
 }
 if (substr($hostname_label, -1, 1) == "-") {
           // error(ERR_DNS_HN_DASH);
   $msg='A hostname can not start or end with a dash.';
   $true=0;
   $result['msg']=$msg;
   $result['true']=$true;
   return $result;
 }
 if (strlen($hostname_label) < 1 || strlen($hostname_label) > 63) {
            //error(ERR_DNS_HN_LENGTH);
   $msg='Given hostname or one of the labels is too short or too long.';
   $true=0;
   $result['msg']=$msg;
   $result['true']=$true;
   return $result;
 }
}

if ($hostname_labels[$label_count - 1] == "arpa" && (substr_count($hostname_labels[0], "/") == 1 XOR substr_count($hostname_labels[1], "/") == 1)) {
  if (substr_count($hostname_labels[0], "/") == 1) {
    $array = explode("/", $hostname_labels[0]);
  } else {
    $array = explode("/", $hostname_labels[1]);
  }
  if (count($array) != 2) {
            //error(ERR_DNS_HOSTNAME);
   $msg='Invalid hostname.';
   $true=0;
   $result['msg']=$msg;
   $result['true']=$true;
   return $result;
 }
 if (!is_numeric($array[0]) || $array[0] < 0 || $array[0] > 255) {
  $msg='Invalid hostname.';
  $true=0;
  $result['msg']=$msg;
  $result['true']=$true;
  return $result;
}
if (!is_numeric($array[1]) || $array[1] < 25 || $array[1] > 31) {
 $msg='Invalid hostname.';
 $true=0;
 $result['msg']=$msg;
 $result['true']=$true;
 return $result;
}
} else {
  if (substr_count($hostname, "/") > 0) {
            //error(ERR_DNS_HN_SLASH);
    $msg='Given hostname has too many slashes.';
    $true=0;
    $result['msg']=$msg;
    $result['true']=$true;
    return $result;

  }
}

return true;
}
//check is IPV4
public	function is_valid_ipv4($ipv4, $answer = true) {
  if (!preg_match("/^[0-9\.]{7,15}$/", $ipv4)) {
    if ($answer) {
           // error(ERR_DNS_IPV4);
    }
    return false;
  }

  $quads = explode('.', $ipv4);
  $numquads = count($quads);

  if ($numquads != 4) {
    if ($answer) {
           // error(ERR_DNS_IPV4);
    }
    return false;
  }

  for ($i = 0; $i < 4; $i++) {
    if ($quads[$i] > 255) {
      if ($answer) {
                //error(ERR_DNS_IPV4);
      }
      return false;
    }
  }

  return true;
}

//check is IPV6
public function is_valid_ipv6($ipv6, $answer = true) {
  if (!preg_match("/^[0-9a-f]{0,4}:([0-9a-f]{0,4}:){0,6}[0-9a-f]{0,4}$/i", $ipv6)) {
    if ($answer) {
            //error(ERR_DNS_IPV6);
    }
    return false;
  }
  $quads = explode(':', $ipv6);
  $numquads = count($quads);
  if ($numquads > 8 || $numquads < 3) {
    if ($answer) {
            //error(ERR_DNS_IPV6);
    }
    return false;
  }
  $emptyquads = 0;
  for ($i = 1; $i < $numquads - 1; $i++) {
    if ($quads[$i] == "")
      $emptyquads++;
  }
  if ($emptyquads > 1) {
    if ($answer) {
            //error(ERR_DNS_IPV6);
    }
    return false;
  }
  if ($emptyquads == 0 && $numquads != 8) {
    if ($answer) {
            //error(ERR_DNS_IPV6);
    }
    return false;
  }
  return true;
}
//check is SOA content
public function is_valid_rr_soa_content($content) {

  $fields = preg_split("/\s+/", trim($content));
  $field_count = count($fields);

  if ($field_count == 0 || $field_count > 7) {
    return false;
  } else {
    if (!$this->is_valid_hostname_fqdn($fields[0], 0) || preg_match('/\.arpa\.?$/', $fields[0])) {
      return false;
    }
    $final_soa = $fields[0];

    if (isset($fields[1])) {
      $addr_input = $fields[1];
    } else {
      global $dns_hostmaster;
      $addr_input = $dns_hostmaster;
    }
    if (!preg_match("/@/", $addr_input)) {
      $addr_input = preg_split('/(?<!\\\)\./', $addr_input, 2);
      $addr_to_check = str_replace("\\", "", $addr_input[0]) . "@" . $addr_input[1];
    } else {
      $addr_to_check = $addr_input;
    }

    if (!$this->is_valid_email($addr_to_check)) {
      return false;
    } else {
      $addr_final = explode('@', $addr_to_check, 2);
      $final_soa .= " " . str_replace(".", "\\.", $addr_final[0]) . "." . $addr_final[1];
    }

    if (isset($fields[2])) {
      if (!is_numeric($fields[2])) {
        return false;
      }
      $final_soa .= " " . $fields[2];
    } else {
      $final_soa .= " 0";
    }

    if ($field_count != 7) {
      return false;
    } else {
      for ($i = 3; ($i < 7); $i++) {
        if (!is_numeric($fields[$i])) {
          return false;
        } else {
          $final_soa .= " " . $fields[$i];
        }
      }
    }
  }
  $content = $final_soa;
  return true;
}
public function is_valid_printable($string) {
  if (!preg_match('/^[[:print:]]+$/', trim($string))) {
        //error(ERR_DNS_PRINTABLE);
    return false;
  }
  return true;
}
public function is_valid_rr_srv_name(&$name) {

  if (strlen($name) > 255) {
       // error(ERR_DNS_HN_TOO_LONG);
    return false;
  }

  $fields = explode('.', $name, 3);
  if (!preg_match('/^_[\w-]+$/i', $fields[0])) {
       // error(ERR_DNS_SRV_NAME);
    return false;
  }
  if (!preg_match('/^_[\w]+$/i', $fields[1])) {
       // error(ERR_DNS_SRV_NAME);
    return false;
  }
  if (!$this->is_valid_hostname_fqdn($fields[2], 0)) {
       // error(ERR_DNS_SRV_NAME);
    return false;
  }
  $name = join('.', $fields);
  return true;
}

public function is_valid_rr_srv_content($content) {
  $fields = preg_split("/\s+/", trim($content), 3);
  if (!is_numeric($fields[0]) || $fields[0] < 0 || $fields[0] > 65535) {
       // error(ERR_DNS_SRV_WGHT);
    return false;
  }
  if (!is_numeric($fields[1]) || $fields[1] < 0 || $fields[1] > 65535) {
       // error(ERR_DNS_SRV_PORT);
    return false;
  }
  if ($fields[2] == "" || ($fields[2] != "." && !$this->is_valid_hostname_fqdn($fields[2], 0))) {
        //error(ERR_DNS_SRV_TRGT);
    return false;
  }
  $content = join(' ', $fields);
  return true;
}
function is_valid_rr_ttl($ttl) {

  if (!isset($ttl) || $ttl == "") {

    $ttl = $dns_ttl;
  }

  if (!is_numeric($ttl) || $ttl < 0 || $ttl > 2147483647) {
        //error(ERR_DNS_INV_TTL);
    return false;
  }

  return true;
}

public function is_valid_spf($content) {
    //Regex from http://www.schlitt.net/spf/tests/spf_record_regexp-03.txt
  $regex = "^[Vv]=[Ss][Pp][Ff]1( +([-+?~]?([Aa][Ll][Ll]|[Ii][Nn][Cc][Ll][Uu][Dd][Ee]:(%\{[CDHILOPR-Tcdhilopr-t]([1-9][0-9]?|10[0-9]|11[0-9]|12[0-8])?[Rr]?[+-/=_]*\}|%%|%_|%-|[!-$&-~])*(\.([A-Za-z]|[A-Za-z]([-0-9A-Za-z]?)*[0-9A-Za-z])|%\{[CDHILOPR-Tcdhilopr-t]([1-9][0-9]?|10[0-9]|11[0-9]|12[0-8])?[Rr]?[+-/=_]*\})|[Aa](:(%\{[CDHILOPR-Tcdhilopr-t]([1-9][0-9]?|10[0-9]|11[0-9]|12[0-8])?[Rr]?[+-/=_]*\}|%%|%_|%-|[!-$&-~])*(\.([A-Za-z]|[A-Za-z]([-0-9A-Za-z]?)*[0-9A-Za-z])|%\{[CDHILOPR-Tcdhilopr-t]([1-9][0-9]?|10[0-9]|11[0-9]|12[0-8])?[Rr]?[+-/=_]*\}))?((/([1-9]|1[0-9]|2[0-9]|3[0-2]))?(//([1-9][0-9]?|10[0-9]|11[0-9]|12[0-8]))?)?|[Mm][Xx](:(%\{[CDHILOPR-Tcdhilopr-t]([1-9][0-9]?|10[0-9]|11[0-9]|12[0-8])?[Rr]?[+-/=_]*\}|%%|%_|%-|[!-$&-~])*(\.([A-Za-z]|[A-Za-z]([-0-9A-Za-z]?)*[0-9A-Za-z])|%\{[CDHILOPR-Tcdhilopr-t]([1-9][0-9]?|10[0-9]|11[0-9]|12[0-8])?[Rr]?[+-/=_]*\}))?((/([1-9]|1[0-9]|2[0-9]|3[0-2]))?(//([1-9][0-9]?|10[0-9]|11[0-9]|12[0-8]))?)?|[Pp][Tt][Rr](:(%\{[CDHILOPR-Tcdhilopr-t]([1-9][0-9]?|10[0-9]|11[0-9]|12[0-8])?[Rr]?[+-/=_]*\}|%%|%_|%-|[!-$&-~])*(\.([A-Za-z]|[A-Za-z]([-0-9A-Za-z]?)*[0-9A-Za-z])|%\{[CDHILOPR-Tcdhilopr-t]([1-9][0-9]?|10[0-9]|11[0-9]|12[0-8])?[Rr]?[+-/=_]*\}))?|[Ii][Pp]4:([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])(/([1-9]|1[0-9]|2[0-9]|3[0-2]))?|[Ii][Pp]6:(::|([0-9A-Fa-f]{1,4}:){7}[0-9A-Fa-f]{1,4}|([0-9A-Fa-f]{1,4}:){1,8}:|([0-9A-Fa-f]{1,4}:){7}:[0-9A-Fa-f]{1,4}|([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}){1,2}|([0-9A-Fa-f]{1,4}:){5}(:[0-9A-Fa-f]{1,4}){1,3}|([0-9A-Fa-f]{1,4}:){4}(:[0-9A-Fa-f]{1,4}){1,4}|([0-9A-Fa-f]{1,4}:){3}(:[0-9A-Fa-f]{1,4}){1,5}|([0-9A-Fa-f]{1,4}:){2}(:[0-9A-Fa-f]{1,4}){1,6}|[0-9A-Fa-f]{1,4}:(:[0-9A-Fa-f]{1,4}){1,7}|:(:[0-9A-Fa-f]{1,4}){1,8}|([0-9A-Fa-f]{1,4}:){6}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])|([0-9A-Fa-f]{1,4}:){6}:([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])|([0-9A-Fa-f]{1,4}:){5}:([0-9A-Fa-f]{1,4}:)?([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])|([0-9A-Fa-f]{1,4}:){4}:([0-9A-Fa-f]{1,4}:){0,2}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])|([0-9A-Fa-f]{1,4}:){3}:([0-9A-Fa-f]{1,4}:){0,3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])|([0-9A-Fa-f]{1,4}:){2}:([0-9A-Fa-f]{1,4}:){0,4}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])|[0-9A-Fa-f]{1,4}::([0-9A-Fa-f]{1,4}:){0,5}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])|::([0-9A-Fa-f]{1,4}:){0,6}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]))(/([1-9][0-9]?|10[0-9]|11[0-9]|12[0-8]))?|[Ee][Xx][Ii][Ss][Tt][Ss]:(%\{[CDHILOPR-Tcdhilopr-t]([1-9][0-9]?|10[0-9]|11[0-9]|12[0-8])?[Rr]?[+-/=_]*\}|%%|%_|%-|[!-$&-~])*(\.([A-Za-z]|[A-Za-z]([-0-9A-Za-z]?)*[0-9A-Za-z])|%\{[CDHILOPR-Tcdhilopr-t]([1-9][0-9]?|10[0-9]|11[0-9]|12[0-8])?[Rr]?[+-/=_]*\}))|[Rr][Ee][Dd][Ii][Rr][Ee][Cc][Tt]=(%\{[CDHILOPR-Tcdhilopr-t]([1-9][0-9]?|10[0-9]|11[0-9]|12[0-8])?[Rr]?[+-/=_]*\}|%%|%_|%-|[!-$&-~])*(\.([A-Za-z]|[A-Za-z]([-0-9A-Za-z]?)*[0-9A-Za-z])|%\{[CDHILOPR-Tcdhilopr-t]([1-9][0-9]?|10[0-9]|11[0-9]|12[0-8])?[Rr]?[+-/=_]*\})|[Ee][Xx][Pp]=(%\{[CDHILOPR-Tcdhilopr-t]([1-9][0-9]?|10[0-9]|11[0-9]|12[0-8])?[Rr]?[+-/=_]*\}|%%|%_|%-|[!-$&-~])*(\.([A-Za-z]|[A-Za-z]([-0-9A-Za-z]?)*[0-9A-Za-z])|%\{[CDHILOPR-Tcdhilopr-t]([1-9][0-9]?|10[0-9]|11[0-9]|12[0-8])?[Rr]?[+-/=_]*\})|[A-Za-z][-.0-9A-Z_a-z]*=(%\{[CDHILOPR-Tcdhilopr-t]([1-9][0-9]?|10[0-9]|11[0-9]|12[0-8])?[Rr]?[+-/=_]*\}|%%|%_|%-|[!-$&-~])*))* *$^";
  if (!preg_match($regex, $content)) {
    return false;
  } else {
    return true;
  }
}
public function is_valid_loc($content) {
  $regex = "^(90|[1-8]\d|0?\d)( ([1-5]\d|0?\d)( ([1-5]\d|0?\d)(\.\d{1,3})?)?)? [NS] (180|1[0-7]\d|[1-9]\d|0?\d)( ([1-5]\d|0?\d)( ([1-5]\d|0?\d)(\.\d{1,3})?)?)? [EW] (-(100000(\.00)?|\d{1,5}(\.\d\d)?)|([1-3]?\d{1,7}(\.\d\d)?|4([01][0-9]{6}|2([0-7][0-9]{5}|8([0-3][0-9]{4}|4([0-8][0-9]{3}|9([0-5][0-9]{2}|6([0-6][0-9]|7[01]))))))(\.\d\d)?|42849672(\.([0-8]\d|9[0-5]))?))[m]?( (\d{1,7}|[1-8]\d{7})(\.\d\d)?[m]?){0,3}$^";
  if (!preg_match($regex, $content)) {
    return false;
  } else {
    return true;
  }
}
public function is_valid_email($address) {
  $fields = preg_split("/@/", $address, 2);
  if ((!preg_match("/^[0-9a-z]([-_.]?[0-9a-z])*$/i", $fields[0])) || (!isset($fields[1]) || $fields[1] == '' || !$this->is_valid_hostname_fqdn($fields[1], 0))) {
    return false;
  }
  return true;
}
//cname

public function is_valid_rr_cname_name($name) {
  $query = "SELECT id FROM records
  WHERE content = " . $db->quote($name, 'text') . "
  AND (type = " . $db->quote('MX', 'text') . " OR type = " . $db->quote('NS', 'text') . ")";

  $response = $db->queryOne($query);

  if (!empty($response)) {
    error(ERR_DNS_CNAME);
    return false;
  }

  return true;
}

public function logs($content)
{
  $file_path=storage_path().'/logs/logs.txt';
  $current = file_get_contents($file_path);
  $file = fopen($file_path,"w");
  $current= $content.'--------'.$current;
  fwrite($file,$current);
  fclose($file);

}

// connect API
public function addheader($field, $content) {
  $this->headers[$field] = $content;
}

private function authheaders() {
  $this->addheader('X-API-Key', $this->auth);
}

private function apiurl() {
  $tmp = new ApiHandler();

  $tmp->url = '/api';
  $tmp->go();

  if ($tmp->json[0]['version'] <= 1) {
    $this->apiurl = $tmp->json[0]['url'];
  } else {
    throw new Exception("Unsupported API version");
  }

}

private function curlopts() {
  $this->authheaders();
  $this->addheader('Accept', 'application/json');

  curl_reset($this->curlh);
  curl_setopt($this->curlh, CURLOPT_HTTPHEADER, Array());
  curl_setopt($this->curlh, CURLOPT_RETURNTRANSFER, 1);

  if (strcasecmp($this->proto, 'https')) {
    curl_setopt($this->curlh, CURLOPT_SSL_VERIFYPEER, $this->sslverify);
  }

  $setheaders = Array();

  foreach ($this->headers as $k => $v) {
    array_push($setheaders, join(": ", Array($k, $v)));
  }
  curl_setopt($this->curlh, CURLOPT_HTTPHEADER, $setheaders);
}

private function baseurl() {
  return $this->proto.'://'.$this->hostname.':'.$this->port.$this->apiurl;
}

private function go() {
  $this->curlopts();
//echo $this->content.'<br>';//exit;
  if ($this->content) {
    $this->addheader('Content-Type', 'application/json');
    curl_setopt($this->curlh, CURLOPT_POST, 1);
    curl_setopt($this->curlh, CURLOPT_POSTFIELDS, $this->content);
  }

  switch ($this->method) {
    case 'POST':
    curl_setopt($this->curlh, CURLOPT_POST, 1);
    break;
    case 'GET':
    curl_setopt($this->curlh, CURLOPT_POST, 0);
    break;
    case 'DELETE':
    case 'PATCH':
    case 'PUT':
    curl_setopt($this->curlh, CURLOPT_CUSTOMREQUEST, $this->method);
    break;
  }

  curl_setopt($this->curlh, CURLOPT_URL, $this->baseurl().$this->url);

        //print "Here we go:\n";
        //print "Request: ".$this->method.' '.$this->baseurl().$this->url."\n";
        //if ($this->content != '') {
        //    print "Content: ".$this->content."\n";
        //}

  $return = curl_exec($this->curlh);
  $code = curl_getinfo($this->curlh, CURLINFO_HTTP_CODE);
  $json = json_decode($return, 1);

  if (isset($json['error'])) {
    throw new Exception("API Error $code: ".$json['error']);
  } elseif ($code < 200 || $code >= 300) {
    if ($code == 401) {
      throw new Exception("Authentication failed. Have you configured your authmethod correct?");
    }
    throw new Exception("Curl Error: $code ".curl_error($this->curlh));
  }

  $this->json = $json;
}

public function call() {
  if (substr($this->url, 0, 1) == '/') {
    $this->apiurl();
  } else {
    $this->apiurl = '/';
  }

  $this->go();
}
// add zone
public function savezone($zone) {


        // We have to split up RRSets and Zoneinfo.
        // First, update the zone

  $zonedata = $zone;
  unset($zonedata['id']);
  unset($zonedata['url']);
  unset($zonedata['rrsets']);

  if (!isset($zone['serial']) or gettype($zone['serial']) != 'integer') {
    $this->method = 'POST';
    $this->url = '/servers/localhost/zones';
    $this->content = json_encode($zonedata);
    $this->call();

    return $api->json;
  }
  $this->method = 'PUT';
  $this->url = $zone['url'];
       //echo "<pre>";print_r($zonedata);//exit;
  $this->content = json_encode($zonedata);
  $this->call();

        // Then, update the rrsets
  if (count($zone['rrsets']) > 0) {
    $this->method = 'PATCH';
    $this->content = json_encode(Array('rrsets' => $zone['rrsets']));
    $this->call();
  }

  return $this->loadzone($zone['id']);
}
public function loadzone($zoneid) {

  $this->method = 'GET';
  $this->url = "/servers/localhost/zones/$zoneid";
  $this->call();

  return $this->json;
}

public function apiaccess()
{
  return view('pages.account.apiaccess'); 
}
//check duplicated record
public function check_duplicated_record($name,$content,$type)
{

  $records=Session::get('records');
 // echo "<pre>";print_r($records);exit;
  if(!$name||!$content||!$type)
  {
    return false;
  }
  $is_ok=0;
  foreach($records as $key=>$value)
  {
   // echo $value['content'];exit;
    //if($value['name']==$name&&$value['content']==$content&&$value['type']==$type)
    if($value['name']==$name&&$value['type']==$type)
    {
      $is_ok=1;
    }

  }
  //echo $is_ok;exit;
  if($is_ok==1)
  {
    return true;
  }
  else
  {
    return false;
  }

}
public function remove_record($name,$type)
{
  //exit('tesst');
  $records=Session::get('records');
//echo "<pre>";print_r($records);
  $session_record=array();
  foreach ($records as $key => $value) {
   if($value['name']==$name&&$value['type']==$type)
   {
    // exit($name);
   }
   else
   {
    $session_record[]=$value;
  } 
}
//echo "<pre>||";print_r($session_record);exit;
 Session::forget('records');//remove session
 Session::put('records', $session_record);
 Session::save();
 //Session::regenerate();
}

}
?>