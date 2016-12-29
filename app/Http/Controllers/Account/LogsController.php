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
class LogsController extends Controller
{	
	public function index()
	{
		$user = Auth::user();
		$user_id  = intval($user->id);	
		$allow=get_permission($user->is_root,$user->permission,'account_logs');
		if($allow)
		{
			$logs = DB::table('logs')->select('logs.id','user_id','domain_id','domain','action','content','logs.created_at','users.name')->leftJoin('users', 'users.id', '=', 'logs.user_id')->orderBy('logs.id', 'desc')->paginate(20);
		}
		else
		{
			$logs = DB::table('logs')->select('logs.id','user_id','domain_id','domain','action','content','logs.created_at','users.name')->leftJoin('users', 'users.id', '=', 'logs.user_id')->where([
				['logs.user_id','=',$user_id]
				])->orderBy('logs.id', 'desc')->paginate(20); 
		}
		$label['add']		=	'label-success';
		$label['update']	=	'label-warning';        
		$label['delete']	=	'label-danger';  
		return view('pages.account.logs')->with(['logs'=>$logs,'label'=>$label]);	
	}
	public function view(Request $request,$id)
	{
		$id=intval($id);
		$user = Auth::user();
		$allow=$this->checkowner($id,'account_logs');
		if($allow)
		{
			$logs 				=	DB::table('logs')->leftJoin('users', 'users.id', '=', 'logs.user_id')->where('logs.id',$id)->first();
			$label['add']		=	'label-success';
			$label['update']	=	'label-warning';        
			$label['delete']	=	'label-danger';
			$content=unserialize($logs->content);
			$content=$content['record'];
			return view('pages.account.log')->with(['logs'=>$logs,'label'=>$label,'content'=>$content]);
		}
		else
		{
			Session::flash('global-error-message', 'Something went wrong'); 
			return Redirect::to('/account/logs');
		}
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
		$domains 	=	DB::table('logs')->where([
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
}
?>