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
    return view('welcome');
});

/* Dashboard */
Route::get('/dashboard', 'DashboardController@index');

/* User Login */
Route::get('/login', 'Auth\AuthController@index');
Route::post('/login', 'Auth\AuthController@authenticate');
Route::get('/logout', 'Auth\AuthController@logout');

/* User Registration */
Route::get('/registration', 'Auth\AuthController@create');
Route::post('/registration', 'Auth\AuthController@store');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


/* Admin Dashboard */
Route::get('/administrator', function () {
    return redirect('/administrator/dashboard');
});
Route::get('/administrator/dashboard', 'Admin\DashboardController@index');
/* Admin */
Route::get('/administrator/login','Admin\Auth\AuthController@index');
Route::post('/administrator/login','Admin\Auth\AuthController@authenticate');
/* Users */
Route::get('/administrator/users','Admin\UsersController@index');
Route::get('/administrator/users/data','Admin\UsersController@showAll');

/* Errors */
Route::get('/401','ErrorsController@code401');
Route::get('/403','ErrorsController@code403');
Route::get('/404','ErrorsController@code404');