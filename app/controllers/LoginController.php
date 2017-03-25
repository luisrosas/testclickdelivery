<?php

class LoginController extends BaseController {

	public function show()
	{
		if(Auth::check())
			return Redirect::to('users');

		return View::make('login');
	}

	public function login()
	{
		$userdata = [
			'email'		=> mb_strtolower(trim(Input::get('email'))),
			'password'	=> Input::get('password'),
			'state'		=> 1
		];

		if(Auth::attempt($userdata, false))
		{
			return Redirect::to('users');
		}else{
			$message = ['message' => 'Usuario o Contraseña incorrecto.<br>Por favor intente nuevamente.', 'type' => 'alert-danger'];
			return Redirect::back()->withErrors($message);
		}
	}

	public function logout()
	{
		Auth::logout();
		$message = ['message' => 'Sesión cerrada correctamente..', 'type' => 'alert-success'];
		return Redirect::to('login')->withErrors($message);
	}

}
