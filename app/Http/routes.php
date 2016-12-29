<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
	return Redirect::to('/account');
    //return view('welcome');
});
//steup
Route::get('setup','Setup\SetupController@step1');
Route::get('setup/step2','Setup\SetupController@step2');
Route::post('setup/step3','Setup\SetupController@step3');
Route::get('setup/step3','Setup\SetupController@powerdns');
Route::post('setup/finish','Setup\SetupController@finish');

Route::get('setup/complete','Setup\SetupController@complete');



Route::group(['prefix' => 'account','namespace' => 'Account','middleware'=>['auth']], function () {
	Route::get('/','AccountController@index');
	Route::get('/domains','DomainsController@domains');
	Route::post('/domain/add','DomainsController@add_domain');
	Route::post('/domain/save_domain','DomainsController@save_domain');
	//edit
	Route::get('/domain/edit/{id}','DomainsController@edit');
	Route::get('/domain/delete/{id}','DomainsController@delete_domain');
	//add record
	Route::post('/domain/add_record','DomainsController@add_record');
	//modify record
	Route::post('/domain/update_record','DomainsController@update_record');
	Route::post('/domain/delete_record','DomainsController@delete_record');
	//profile
	Route::get('/profile','AccountController@profile');
	Route::post('/avatar','AccountController@avatar');
	Route::post('/biography','AccountController@biography');
	Route::post('/signature','AccountController@signature');
	Route::post('/setting','AccountController@setting');
	Route::post('/changepass','AccountController@changepass');

	Route::get('/configttl','AccountController@configttl');
	Route::post('/configttl','AccountController@configttlsave');

	//logs
	Route::get('/logs','LogsController@index');
	Route::get('/log/view/{id}','LogsController@view');
	Route::get('/apiaccess','DomainsController@apiaccess');




});
//user login & logout
Route::group(['prefix' => 'login','namespace' => 'Login'], function () {
	Route::get('/', 'LoginController@index');
	Route::post('/login', 'LoginController@login');
	Route::get('/logout', 'LoginController@logout');
});
//register
Route::get('/register', 'Login\RegisterController@register');
Route::post('/register', 'Login\RegisterController@doregister');


// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('home',function(){
	return Redirect::to('/account');
});
//settings
Route::get('settings', 'Settings\SettingsController@index')->middleware('auth');
Route::post('settings', 'Settings\SettingsController@update')->middleware('auth');
Route::get('synchronize', 'Settings\SynchronizeController@index')->middleware('auth');
Route::get('synchronize/autocomplete', 'Settings\SynchronizeController@autocomplete')->middleware('auth');
Route::post('synchronize/synctolocal', 'Settings\SynchronizeController@synctolocal')->middleware('auth');
Route::post('synchronize/delete', 'Settings\SynchronizeController@delete')->middleware('auth');

Route::get('users','User\UserController@index');
Route::group(['prefix' => 'user','namespace' => 'User','middleware'=>['auth']], function () {
	//Route::get('/','UserController@index');
	Route::get('/groups','GroupController@index');
	Route::post('/group/add','GroupController@add');
	Route::get('/group/edit/{id}','GroupController@edit');
	
	Route::post('/group/edit','GroupController@update');
	Route::get('/add','UserController@add');
	Route::post('/store','UserController@store');
	Route::get('/edit/{id}','UserController@edit');
	Route::get('/view/{id}','UserController@view');
	Route::post('/update','UserController@update');
	Route::get('/delete/{id}','UserController@delete');

});




