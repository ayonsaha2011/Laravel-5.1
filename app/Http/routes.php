<?php

Route::get('/', function () {
    return view('welcome');
});





Route::controllers([
	'password' => 'Auth\PasswordController',
]);

/***************************admin*******************************************/
Route::group(['namespace' => 'Admin'], function()
{
	Route::get('sspanel',array('as'=>'sspanel','uses'=>'AuthController@index'));
	Route::post('sspanel/login',array('as'=>'login','uses'=>'AuthController@doLogin'));
	Route::get('sspanel/forgetpassword',array('as'=>'forgetpassword','uses'=>'AuthController@forgetpassword'));
	Route::get('logout',array('as'=>'logout','prefix' => 'panelarea','uses'=>'AuthController@doLogout'));


	Route::group(['middleware' => 'auth'], function()
		{
			Route::get('panelarea/',array('as'=>'panelarea','uses'=>'PanelareaController@index'));
			Route::get('panelarea/profile',array('as'=>'profile','uses'=>'PanelareaController@profile'));
			Route::post('panelarea/profile',array('as'=>'profile','uses'=>'PanelareaController@profileUpdate'));
		});

	Route::group(['prefix' => 'panelarea', 'middleware' => 'admin'], function()
	{
		Route::get('/crud-generate',array('as'=>'crudgenerate','uses'=>'PanelareaController@crud'));
		Route::post('/crud-generate',array('as'=>'crudgenerate','uses'=>'PanelareaController@crudgenerate'));

		Route::get('/artisan-commands',array('as'=>'artisancommands','uses'=>'PanelareaController@artisan'));
		Route::post('/artisan-commands',array('as'=>'artisancommands','uses'=>'PanelareaController@artisancommands'));

	});
});
