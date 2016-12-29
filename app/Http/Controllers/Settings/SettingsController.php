<?php
namespace App\Http\Controllers\Settings;
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
class SettingsController extends Controller
{	
	public function __construct() {
		$user = Auth::user();
		$user_id = intval($user->id);
		$group_id=intval($user->group_id);
  		//need to check again user permission		
		$allow=get_permission($user->is_root,$user->permission,'settings_edit');
		if(!$allow)
		{
			exit("You don't have permission to view this page");
		}
	}
	public function index()
	{
		$settings   =   DB::table('settings')->where('key','apiaccess')->first();
		$settings=unserialize($settings->value);
		return view('pages.settings.index')->with(['settings'=>$settings]);	
		
	}
	public function update(Request $request)
	{
		$post		=	$request->input('name');
		$settings   =   DB::table('settings')->where('key','apiaccess')->first();
		$settings 	=	unserialize($settings->value);
		foreach ($settings as $key => $value) {
			
			$settings[$key]['value']=$post[$key];
		}
		$data=array('value'=> serialize($settings));

		DB::table('settings')->where('key','apiaccess')->update($data);
	//save TTL
		$id=intval(Auth::user()->id);
		$ttl 		=	intval($request->input('ttl'));
		$data=array(
			'ttl'		=>	$ttl,
			);
		DB::table('users')->where('id',$id)->update($data);
		Session::flash('success', 'Settings  successfully updated'); 
		return Redirect::to('settings');
		
	}

}
?>