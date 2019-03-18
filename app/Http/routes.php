<?php

Route::group(['middleware' => ['web']], function () {

	// home
	Route::get('/', [
		'uses' => 'HomeController@index', 
		'as' => 'home'
	]);

    // authentication routes
    Route::get('auth/login', 'Auth\AuthController@getLogin');
    Route::post('auth/login', 'Auth\AuthController@postLogin');
    Route::get('auth/logout', 'Auth\AuthController@getLogout');

    // station routes
    Route::get('station/data', 'StationController@getData');
    Route::get('station/{id}/delete', 'StationController@delete');
    Route::resource('station', 'StationController');
    Route::get('locate/station', 'StationController@getNearestStations');

    // bus routes
    Route::get('bus/data', 'BusController@getData');
    Route::get('bus/{id}/delete', 'BusController@delete');
    Route::resource('bus', 'BusController');

    // schedule routes
    Route::get('schedule/data', 'ScheduleController@getData');
    Route::get('schedule/{id}/delete', 'ScheduleController@delete');
    Route::resource('schedule', 'ScheduleController');

    // User
	Route::get('user/sort/{role}', 'UserController@indexSort');
	Route::get('user/roles', 'UserController@getRoles');
	Route::post('user/roles', 'UserController@postRoles');

    Route::resource('user', 'UserController');
});