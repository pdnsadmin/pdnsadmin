<?php
namespace App\Http\Controllers\Login;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use DB; 
use Validator;
use Session;
use Storage;
use Auth;


class LoginController extends Controller
{
		public function index()
		{
			# exit('sss');
			return view('pages.login.index');
		}
		public function login(Request $request)
		{
			
		$data = Input::all();
		// Applying validation rules.
		$rules = array(
		'email' => 'required|email',
		'password' => 'required|min:6',
		 );
		$validator = Validator::make($data, $rules);
		//print_r($validator);exit;
		if ($validator->fails()){
		// If validation falis redirect back to login.
		return Redirect::to('/login')->withInput(Input::except('password'))->withErrors($validator);
		}
		else {
			$remember = (Input::has('remember')) ? true : false;
			$userdata = array(
			    'email' => Input::get('email'),
			    'password' => Input::get('password'),
			    'active' => 1
			  );
		// doing login.
			if (Auth::validate($userdata)) {
			if (Auth::attempt($userdata,$remember)) {
			  return Redirect::intended('/account');
			}
		} 
		else {
		// if any error send back with message.
			Session::flash('error-message', 'Some thing went wrong'); 
			return Redirect::to('login');
		}
		}
		}
		public function logout()
		{
			Auth::logout();
			return Redirect::to('login');
		}

		public function register()
		{
			
		}

}
?>