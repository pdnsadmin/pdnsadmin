<?php
namespace App\Http\Controllers\Setup;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Validator;
use Illuminate\Support\Facades\Input;
use DB;
use File;
use Hash;
use App\User;
use Session;
class SetupController extends Controller
{
	var $lock_file;
	public function __construct()
	{
		//echo $_SERVER['DOCUMENT_ROOT'].'/uploads/.lock';exit;
		$this->lock_file =$_SERVER['DOCUMENT_ROOT'].'/uploads/.lock';
	}
	public function checkpermission()
	{
	if(is_file($this->lock_file))
	{
		exit('You don\'t have permission');
	}	
	}
	
	public function step1()
	{
		$this->checkpermission();
		return view('pages.setup.step1');
	}
	public function step2()
	{
		$this->checkpermission();
		return view('pages.setup.step2');
	}
	public function step3(Request $request)
	{
		$this->checkpermission();
		if($_SERVER['SERVER_PORT']==80)
	    {
	    	$domain='http://'.$_SERVER['SERVER_NAME'];
	    }
	    else
	    {
	    	$domain='https://'.$_SERVER['SERVER_NAME'];
	    }

		$servername 	= 	Input::get('localhost');
		$username 		= 	Input::get('databaseusername');
		$password 		=	Input::get('serverpassword');
		$database 		=	Input::get('databasename');
		
$fp = fopen('../.env', 'w');//create database
$env="APP_ENV=local
APP_DEBUG=true
APP_KEY=base64:XcMhlm6VDiczYI6WZO6YM7n3SRhmU6tNnFRrW704oMs=
APP_URL=$domain

DB_CONNECTION=mysql
DB_HOST=$servername
DB_PORT=3306
DB_DATABASE=$database
DB_USERNAME=$username
DB_PASSWORD=$password

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null";

fwrite($fp,$env);
//fwrite($fp, '23');
fclose($fp);
//check database connect tion
 
		


   try {
       $conn = new \mysqli($servername, $username, $password,$database);
       $conn->close();
		// Check connection
		
    } catch (\Exception $e) {

      //die("Connection failed");
    	Session::flash('error', 'Connection failed.');
      return redirect()->back();
    }
    return redirect('setup/step3');
exit;
}
public function powerdns()
{
	$this->checkpermission();
	return view('pages.setup.step3');
}
public function finish(Request $request){
	$this->checkpermission();
\Artisan::call('migrate:refresh');

//\Artisan::call('migrate', array('--path' => 'app/migrations'));
//\ Artisan::call('migrate', ['--path'=> "app/database/migrations"]);
		$email			=	Input::get('email');
		$now=date('Y-m-d h:i:s',time());
		$upassword=Input::get('upassword');
		$user 		 		=	new User;
		$user->name 		=	$request->input('name');
		$user->is_root 		=	1;
		$user->email 		=	$email;
		$user->username 	=	$email;
		$user->password 	=	bcrypt($upassword);
		$user->save();
		$hostmaster=$request->input('hostmaster');
		$api_port=$request->input('api_port');
		$zonepath=$request->input('zonepath');
		$api_protocol=$request->input('api_protocol');
		$api_key=$request->input('api_key');
		$ns1=$request->input('ns1');
		$ns2=$request->input('ns2');
		$hostmaster_record_soa=$request->input('hostmaster_record_soa');
		//$hostmaster=$request->input('name');
		$data=array(   
            'hostmaster'        =>array(
                'name'=>'Host master',
                'value'=>$hostmaster),
            'api_port'          =>array(
                'name'=>'Port',
                'value'=>$api_port),
            'zonepath'         =>array(
                'name'=>'Zone path',
                'value'=>$zonepath),   
            'api_protocol'      =>array(
                'name'=>'Protocol',
                'value'=>$api_protocol),
            'api_key'           =>    array(
                'name'=>'Api key',
                'value'=>$api_key),  
            'api_sslverify'     =>array(
                'name'=>'SSL Verify',
                'value'=>'FALSE'),
            'ns1'               =>array(
                'name'=>'The value of the first NS-record',
                'value'=>$ns1),
            'ns2'                =>array(
                'name'=>'The value of the second NS-record',
                'value'=>$ns2),
            'hostmaster_record_soa'                =>array(
                'name'=>'Hostmaster record',
                'value'=>$hostmaster_record_soa),
            );
        $data=serialize($data);
        DB::table('settings')->insert([
            'key'		=>	'apiaccess',
            'value'		=>	$data,
            'created_at' => date('Y-m-d h:i:s',time()),
            ]);
      	$fp = fopen($this->lock_file, 'w');//write lock file
		fwrite($fp,'Locked');
		fclose($fp);  
		$setupinformation=array(
			'email'=>$email,
			'database'=>$_ENV["DB_DATABASE"],
			'username'=>$_ENV["DB_USERNAME"],
			);
		 Session::put('setupinformation', $setupinformation);
      	 Session::save();
	return Redirect::to('/setup/complete');
	}
public function complete()
{
	 $setupinformation=Session::get('setupinformation');
	return view('pages.setup.complete')->with(['setupinformation'=>$setupinformation]);
}

}
?>