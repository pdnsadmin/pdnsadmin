<?php
namespace App\Http\Controllers\Account;
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
class AccountController extends Controller
{

	
	public function index()
	{
		$user = Auth::user();
		$user_id = intval($user->id);
		//how many percent user profile have been updated
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
		//check permission
		$allow=get_permission($user->is_root,$user->permission,'account_domains');
		
		//count how many domain in the system
		 if($allow)//check if it is admin
		 {
		 	$domain_count = DB::table('domains')->count();
		 }
		 else
		 {
		 	$domain_count = DB::table('domains')->where([['user_id','=',$user_id]])->count();
		 }
        if($allow)//check if it is admin
        {
        	$domains    =   DB::table('domains')->orderBy('id', 'desc')->take(10)->get();
        	$logs	=   DB::table('logs')->orderBy('id', 'desc')->take(10)->get();   
        }
        else
        {
        	$domains    =   DB::table('domains')->where([
        		['user_id','=',$user_id]
        		])->orderBy('id', 'desc')->take(10)->get();
        	$logs	=   DB::table('logs')->where([
        		['user_id','=',$user_id]
        		])->orderBy('id', 'desc')->take(10)->get();
        }
        $label['add']		=	'label-success';
        $label['update']	=	'label-warning';        
        $label['delete']	=	'label-danger';        
        return view('pages.account.index')->with(['domain_count'=>intval($domain_count),'percent'=>$percent,'domains'=>$domains,'logs'=>$logs,'label'=>$label]);		
    }
    public function profile()
    {

    	return view('pages.account.profile');
    }
    public function avatar(Request $request)
    {
    	$id=intval(Auth::user()->id);
    	$file = array('image' => Input::file('image'));
  // setting up rules
  $rules = array('image' => 'required| mimes:jpeg,jpg,png | max:1000',); //mimes:jpeg,bmp,png and for max size max:10000
  // doing the validation, passing post data, rules and the messages
  $validator = Validator::make($file, $rules);
  if ($validator->fails()) {
    // send back to the page with the input data and errors
  	Session::flash('error', 'Allow upload format file: .jpeg,.bmp,.png and for max size max:10000');
  	return Redirect::to('account/profile')->withInput()->withErrors($validator);
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

      $data=array(
      	'avatar' 	=> $fileName
      	);

      try {
      	File::delete($destinationPath.'/'.Auth::user()->avatar);
      	DB::table('users')->where('id',$id)->update($data);

      } catch(Exception $e){
      	return redirect()->back()->witch('error','There have some problem to update your content');
      }
      return Redirect::to('account/profile');
  }
  else {
      // sending back with error message.
  	Session::flash('error', 'uploaded file is not valid');
  	return Redirect::to('account/profile');
  }
}
}
public function biography(Request $request)
{
	$id=intval(Auth::user()->id);
	$biography 	=	$request->input('biography');
	if(!$biography)
	{
		Session::flash('error', 'Say something about you');
	}
	else
	{
		$data=array(
			'biography' 	=> $biography
			);
		Session::flash('success', 'update biography  successfully'); 
		DB::table('users')->where('id',$id)->update($data);
	}
	return Redirect::to('account/profile');
}
public function signature(Request $request)
{
	$id=intval(Auth::user()->id);
	$signature 	=	$request->input('signature');
	if(!$signature)
	{
		Session::flash('error', 'Input your signature please');
	}
	else
	{
		$data=array(
			'signature' 	=> $signature
			);
		Session::flash('success', 'update signature  successfully'); 
		DB::table('users')->where('id',$id)->update($data);
	}
	return Redirect::to('account/profile');
}
public function setting(Request $request)
{
	$id=intval(Auth::user()->id);
	$name 		=	$request->input('name');
	$phone 		=	$request->input('phone');
	$jobtitle 	=	$request->input('jobtitle');
	$location 	=	$request->input('location');
	$ttl 		=	intval($request->input('ttl'));
	if(!$name)
	{
		Session::flash('error', 'Input your name please');
	}
	else
	{
		$data=array(
			'name' 		=> 	$name,
			'phone' 	=> 	$phone,
			'jobtitle' 	=> 	$jobtitle,
			'location' 	=> 	$location,
      	//'ttl'		=>	$ttl,
			);
      	//echo "<pre>";print_r($data);exit;
		Session::flash('success', 'update your profile  successfully'); 
		DB::table('users')->where('id',$id)->update($data);
	}
	return Redirect::to('account/profile#settings');
}
public function changepass(Request $request)
{
	$id=intval(Auth::user()->id);
	$password 		=	$request->input('password');
	$repassword 	=	$request->input('repassword');
	$oldpassword 	=	$request->input('oldpassword');
	if(!$password||($password!=$repassword))
	{
		Session::flash('error', 'Please make sure your passwords match');
	}
	if(strlen($password)<6)
	{
		Session::flash('error', 'Please enter at least 6 characters.');
	}
	elseif(!$oldpassword)
	{
		Session::flash('error', 'Please enter your current password');
	}
	elseif(!Hash::check( $oldpassword, Auth::user()->password))
	{
		Session::flash('error', 'Your current password is missing or incorrect');
	}	
	else
	{
		$data=array(
			'password' 		=> 	bcrypt($password),
			);
      	//echo "<pre>";print_r($data);exit;
		Session::flash('success', 'Your password has been changed successfully'); 
		DB::table('users')->where('id',$id)->update($data);
	}
	return Redirect::to('account/profile#changepass');
}
public function configttl()
{
	return view('pages.account.configttl');
}
public function configttlsave(Request $request)
{
	$id=intval(Auth::user()->id);
	$ttl=$request->input('ttl');
	$data=array(
		'ttl'		=>	$ttl,
		);
	Session::flash('success', 'TTL successfully updated'); 
	DB::table('users')->where('id',$id)->update($data);
	
	return Redirect::to('account/configttl');
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