<?php
namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
use App\Usergroups;
use Validator;
use Illuminate\Support\Facades\Input;
use Session;
use File;
use Hash;
use DateTime;
class GroupController extends Controller
{
	public function index()
	{
		$user = Auth::user();
		$user_id = intval($user->id);
		$allow=get_permission($user->is_root,$user->permission,'user_groups');
		 if(!$allow)//check if it is admin
		 {
		 	exit("You don't have permission to view this page");
		 }
		 $percent=40;
		 $array['avatar']	=$user->avatar;
		 $array['biography']	=$user->biography;
		 $array['signature']	=$user->signature;
		 $array['jobtitle']	=$user->jobtitle;
		 $array['phone']		=$user->phone;
		 $array['location']	=$user->location;
		 foreach ($array as $key => $value) {
		 	if($value)
		 	{
		 		$percent=$percent+10;
		 	}
		 }
		 $group_id=intval($user->group_id);
		 $groups 	=	DB::table('usergroups')->orderBy('name','ASC')->get();
		 return view('pages.user.groups.index')->with(['groups'=>$groups]);	
		 
		}
		

		public function add(Request $request)
		{
			$user = Auth::user();
			$user_id = intval($user->id);
			$allow=get_permission($user->is_root,$user->permission,'user_group_add');
		 if(!$allow)//check if it is admin
		 {
		 	exit("You don't have permission to view this page");
		 }
		 $now=$time=date('Y-m-d h:s:i');
		 $group=$request->input('group');     
		 $Usergroups = new Usergroups;
		 $Usergroups->name     			=   $group;
		 $Usergroups->created_at        =   $now;
		 $Usergroups->updated_at	    =   $now;
		 $Usergroups->save();
		 $data['name']=$group;
		 $data['id']=$Usergroups->id;
		 $data['created_at']=$time;
		 $data['updated_at']=$time;
		 $data['error']='';
		 echo json_encode($data);
		}
		public function edit(Request $request,$id)
		{
			$user = Auth::user();
			$user_id = intval($user->id);
			$allow=get_permission($user->is_root,$user->permission,'user_group_edit');
		 if(!$allow)//check if it is admin
		 {
		 	exit("You don't have permission to edit this group");
		 }
		 $id=intval($id);
		 $Usergroups = new Usergroups;
		 $group=$Usergroups->find($id);
		 $permission = unserialize( $group->permission );
		 if(!is_array($permission))
		 	$permission=array();
		 return view('pages.user.groups.edit')->with(['group'=>$group,'permission'=>$permission]);
		}
		public function update(Request $request)
		{
			$user = Auth::user();
			$user_id = intval($user->id);
			$allow=get_permission($user->is_root,$user->permission,'user_group_edit');
		 if(!$allow)//check if it is admin
		 {
		 	exit("You don't have permission to edit this group");
		 }
		 $id=$request->input('id');  
		 $permission = array();
		 $pdata = $_POST;
		 $permit = array_keys($_POST);
		 for ( $i = 0; $i < count($pdata); $i++ )
		 {
		 	if ( count(explode("_", $permit[$i])) > 1 )
		 	{
		 		if($pdata[$permit[$i]]==1)
		 			$permission[$permit[$i]] = $pdata[$permit[$i]];
		 	}
		 }
		 $permission = serialize( $permission );
		 $now=date('Y-m-d h:s:i');
		 $data=array(
		 	'name' 	=> $request->input('name'),
		 	'permission' 	=> $permission,
		 	'updated_at'	=>	$now,
		 	);
		 try {
		 	DB::table('usergroups')->where('id',$id)->update($data);
		 	return redirect()->back()->with('error','Group successfully updated');
        	//return Redirect::to('/user/group/edit/'.$id);
		 } catch(Exception $e){
		 	return redirect()->back()->with('error','There have some problem to update your content');
		 }
		}
		public function store(Request $request)
		{
        // Validate the request...

			$flight = new Flight;

			$flight->name = $request->name;

			$flight->save();
		}

	}
	?>