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
use App\User;


class RegisterController extends Controller
{
		public function register()
		{
			
			return view('pages.login.register');
		}
		public function doregister(Request $request)
		{
		$data = Input::all();		
		$rules = array(
		'name' => 'required',
		'email' => 'required|email|unique:users',
		'password' => 'required|min:6',
		 );
		$validator = Validator::make($data, $rules);
		if ($validator->fails()){
		// If validation falis redirect back to login.
		return Redirect::to('/register')->withInput(Input::except('password'))->withErrors($validator);
		}
		else
		{
		$user 		 		=	new User;
		$user->name 		=	$request->input('name');
		$user->email 		=	$request->input('email');
		$user->username 	=	$request->input('email');

		$user->password 	=	bcrypt($request->input('password'));
		$user->save();
		Session::flash('error-message', 'Your account have been created'); 
		return Redirect::to('login');
		}
		
		//exit('okies okies');
		}
		

}
?>