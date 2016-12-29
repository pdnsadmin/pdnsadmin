<?php
namespace App\Http\Controllers\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
use Validator;
use Illuminate\Support\Facades\Input;
use Session;
use File;
use Hash;
use App\User;
class UserController extends Controller
{	
	public function index()
	{

		$user = Auth::user();
		$user_id = intval($user->id);
		$allow=get_permission($user->is_root,$user->permission,'user_read');
		 if(!$allow)//check if it is admin
		 {
		 	exit("You don't have permission to view this page");
		 }
		 $groups = DB::table('usergroups')->orderBy('name', 'desc')->get();
		 if(is_array($groups))
		 {
		 	$group_tmp=array();
		 	$group_tmp[0]='';
		 	foreach ($groups as $key => $value) {
		 		$group_tmp[$value->id]=$value->name;
		 	}
		 	$groups=$group_tmp;
		 }
		 else
		 {
		 	$groups=array();	
		 }
		 $users = DB::table('users')->where('active',1)->orderBy('id', 'desc')->paginate(20); 
		 return view('pages.user.users.index')->with(['users'=>$users,'groups'=>$groups]);	
		}
		public function edit(Request $request,$id)
		{
			$user = Auth::user();
			$user_id = intval($user->id);
			$allow=get_permission($user->is_root,$user->permission,'user_edit');
		 if(!$allow)//check if it is admin
		 {
		 	exit("You don't have permission to modify this user");
		 }
		 $users 				=	DB::table('users')->where('id',$id)->first();
		 $groups = DB::table('usergroups')->orderBy('name', 'desc')->get();
		 $permission = unserialize( $users->permission );
		 if(!is_array($permission))
		 	$permission=array();
		 return view('pages.user.users.edit')->with(['users'=>$users,'groups'=>$groups,'permission'=>$permission]);	
		}
		public function view(Request $request,$id)
		{
			$users 				=	DB::table('users')->where('id',$id)->first();
			$groups = DB::table('usergroups')->where('id',$users->group_id)->first();
			if(!is_object($groups))
			{	
				$groups = (object) array('0' => '0','name'=>'');
			}
			$is_root[0]='No';
			$is_root[1]='Yes';
			$is_root=$is_root[$users->is_root];
			return view('pages.user.users.view')->with(['users'=>$users,'groups'=>$groups,'is_root'=>$is_root]);	
		}
		public function delete(Request $request,$id)
		{
			$user = Auth::user();
			$user_id = intval($user->id);
			$allow=get_permission($user->is_root,$user->permission,'user_delete');
		 if(!$allow)//check if it is admin
		 {
		 	exit("You don't have permission to delete this user");
		 }
		 $data=array(
		 	'active' 			=> 	0,
			//'updated_at'	=>	$now,
		 	);
		 DB::table('users')->where('id',$id)->update($data);
		 Session::flash('error', 'User successfully deleted.');
		 return redirect('users');
		} 
		public function update(Request $request)
		{
			$user = Auth::user();
			$user_id = intval($user->id);
			$allow=get_permission($user->is_root,$user->permission,'user_edit');
			$update=intval($request->input('update'));
		 if(!$allow)//check if it is admin
		 {
		 	exit("You don't have permission to delete this user");
		 }
		 $id=intval($request->input('id'));
		 $error=0;
		 $permission = array();
		 $now=date('Y-m-d h:s:i');
		 $data=array(
		 	'name' 			=> 	$request->input('name'),
		 	'phone' 		=> 	$request->input('phone'),
		 	'group_id'		=>	intval($request->input('group_id')),
		 	'jobtitle' 		=> 	$request->input('jobtitle'),
		 	'biography' 	=> 	$request->input('biography'),
		 	'is_root'		=>	intval($request->input('isroot')),
		 	'signature' 	=> 	$request->input('signature'),
		 	'location' 		=> 	$request->input('location'),
		 	'overview' 		=> 	$request->input('overview'),
		 	'notes' 		=> 	$request->input('notes'),
		 	);
		 if($update!=1):
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
		 $data["permission"]=$permission;
		 else:
		 	$groups = DB::table('usergroups')->where('id',intval($request->input('group_id')))->first();
		 $permission = $groups->permission;
		 $data["permission"]=$permission;
		 endif;	
	//check if change password
		 $password 		=	$request->input('password');
		 if($password):
		 	if(strlen($password)<6)
		 	{
		 		$error=1;
		 		Session::flash('error', 'Password: please enter at least 6 characters.');
		 	}
		 	else
		 	{
		 		$data['password']=bcrypt($password);    	
		 	}	
		 	endif; 	
		 	/*Change avarta*/
		 	$file = array('image' => Input::file('image'));
		 	if(Input::file('image')):
  // setting up rules
  $rules = array('image' => 'required| mimes:jpeg,jpg,png | max:1000',); //mimes:jpeg,bmp,png and for max size max:10000
  // doing the validation, passing post data, rules and the messages
$validator = Validator::make($file, $rules);
if ($validator->fails()) {
	$error=1;
    // send back to the page with the input data and errors
	Session::flash('error', 'Allow upload format file: .jpeg,.bmp,.png and for max size max:10000');
  	//return redirect()->back()->withInput()->withErrors($validator);
  	//return Redirect::to('account/profile')->withInput()->withErrors($validator);
}
else {
    // checking file is valid.
	if (Input::file('image')->isValid()) {
      $destinationPath = 'uploads'; // upload path
      $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
      $fileName = rand(11111,99999).'.'.$extension; // renameing image
      Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
      // sending back with message
      Session::flash('success', 'Upload successfully'); 
      $datasave=array(
      	'avatar' 	=> $fileName
      	);
      try {
      	File::delete($destinationPath.'/'.Auth::user()->avatar);
      	DB::table('users')->where('id',$id)->update($datasave);
      } catch(Exception $e){
      	$error=1;
      	Session::flash('error', 'There have some problem to update your content');
      	//return redirect()->back()->with('error','There have some problem to update your content');
      }
  }
}
endif;
/*end change avatar*/
if($error==0):
	DB::table('users')->where('id',$id)->update($data);
return redirect()->back()->with('success','User successfully updated');
else:
	return redirect()->back();
endif;      	

}
public function add()
{
	$user = Auth::user();
	$user_id = intval($user->id);
	$allow=get_permission($user->is_root,$user->permission,'user_add');
	$allow=true;
		 if(!$allow)//check if it is admin
		 {
		 	exit("You don't have permission to delete this user");
		 }
		 $groups = DB::table('usergroups')->orderBy('name', 'desc')->get();
		 return view('pages.user.users.add')->with(['groups'=>$groups]);
		}	    
		function store(Request $request)
		{
			$user = Auth::user();
			$user_id = intval($user->id);
			$allow=get_permission($user->is_root,$user->permission,'user_add');		
			$allow=true;
		 if(!$allow)//check if it is admin
		 {
		 	exit("You don't have permission to delete this user");
		 }
		 $add_user 		 		=	new User;
		 $id=intval($request->input('id'));
		//echo $update;exit;
		 $error=0;
		 $permission = array();
		 $now=date('Y-m-d h:s:i');
		 $add_user->name 			=	$request->input('name');
		 $add_user->email 			=	$request->input('email');
		 $add_user->username 		=	$request->input('email');
		 $add_user->phone			=	$request->input('phone');
		 $add_user->group_id			=	intval($request->input('group_id'));
		 $add_user->jobtitle			= 	$request->input('jobtitle');
		 $add_user->biography		= 	$request->input('biography');
		 $add_user->is_root			=	intval($request->input('isroot'));
		 $add_user->signature		= 	$request->input('signature');
		 $add_user->location			= 	$request->input('location');
		 $add_user->overview			= 	$request->input('overview');
		 $add_user->notes			= 	$request->input('notes');
		 if($request->input('group_id')<=0):
		 	$data["permission"]='';
		 else:
		 	$groups = DB::table('usergroups')->where('id',intval($request->input('group_id')))->first();
		 $permission = $groups->permission;
		 $data["permission"]=$permission;
		 endif;
		 $password 		=	$request->input('password');
		 if(strlen($password)<6)
		 {
		 	$error=1;
		 	Session::flash('error', 'Password: please enter at least 6 characters.');
		 }
		 else
		 {
		 	$data['password']=bcrypt($password);    	
		 } 	
		 /*upload avarta*/
		 $file = array('image' => Input::file('image'));
		 if(Input::file('image')):
  // setting up rules
  $rules = array('image' => 'required| mimes:jpeg,jpg,png | max:1000',); //mimes:jpeg,bmp,png and for max size max:10000
  // doing the validation, passing post data, rules and the messages
$validator = Validator::make($file, $rules);
if ($validator->fails()) {
	$error=1;
    // send back to the page with the input data and errors
	Session::flash('error', 'Allow upload format file: .jpeg,.bmp,.png and for max size max:10000');
}
else {
    // checking file is valid.
	if (Input::file('image')->isValid()) {
      $destinationPath = 'uploads'; // upload path
      $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
      $fileName = rand(11111,99999).'.'.$extension; // renameing image
      Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
      // sending back with message
      Session::flash('success', 'Upload successfully'); 
      $add_user->avatar= $fileName;
  }
}
endif;
/*end upload avatar*/
if($error==0):
	$add_user->save();
return redirect('users')->with('success','User successfully created');
else:
	return redirect()->back();
endif;
}

}
?>