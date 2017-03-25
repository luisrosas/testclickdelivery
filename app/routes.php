<?php

Route::get('/', function(){
	if(Auth::check())
		return Redirect::to('users');
	return View::make('home');
});


// Rutas login
Route::get('login', 'LoginController@show');
Route::post('login', 'LoginController@login');
Route::get('login/fb', 'FacebookController@login');
Route::get('login/fb/callback', 'FacebookController@callbackLogin');


//Rutas resgistro
Route::get('register', 'RegisterController@show');
Route::post('register', 'RegisterController@store');
Route::get('register/fb', 'FacebookController@register');
Route::get('register/fb/callback', 'FacebookController@callbackRegister');


// Ruta Logout
Route::get('logout', 'LoginController@logout');


// Validar Auth
Route::group(['before' => 'auth'], function(){

	// Ruta Editar mi perfil
	Route::get('me/edit', 'MeController@edit');
	Route::put('me/edit', 'MeController@update');


	// Ruta Usuarios
	Route::get('users', 'UserController@index');
		// Crear agente
	Route::get('users/create-agente', 'UserController@create');
	Route::post('users/create-agente', 'UserController@store');
		// Editar usuario
	Route::get('users/edit/{id}', 'UserController@edit');
	Route::put('users/edit/{id}', 'UserController@update');
		// Eliminar usuario
	Route::delete('users/{id}', 'UserController@destroy');

	// Vincular una cuenta con Facebook
	Route::get('add-account/fb', 'FacebookController@addAccount');
	Route::get('add-account/fb/callback', 'FacebookController@callbackAddAccount');
});

// Ruta Activar mi cuenta
Route::get('activation/{code}', 'UserController@activation');