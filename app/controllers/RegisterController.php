<?php

class RegisterController extends BaseController {

	public function show()
	{
		if(Auth::check())
			return Redirect::to('users');
		
		return View::make('register');
	}

	public function store()
	{
		$data = array(
			'nombre'					=> Input::get('name'),
			'correo'					=> mb_strtolower(trim(Input::get('email'))),
			'teléfono'					=> Input::get('phone'),
			'contraseña'				=> Input::get('password'),
			'confirmación_contraseña'	=> Input::get('password_r'),
		);
		$rules = array(
			'nombre'					=> 'required|max:60',
			'correo'					=> 'required|email|unique:users,email|max:100',
			'teléfono'					=> 'max:20',
			'contraseña'				=> 'required|min:6',
			'confirmación_contraseña'	=> 'required|same:contraseña'
		);
		$messages = array(
			'required'		=> 'El campo :attribute es requerido.',
			'unique'		=> 'Ya existe un usuario registrado con el :attribute ('.mb_strtolower(trim(Input::get('email'))).').',
			'confirmed'		=> 'La confirmación de la :attribute no coinciden.',
			'email'			=> 'El formato del :attribute no es válido.',
			'max' 			=> 'El campo :attribute no puede tener más de :max carácteres.',
			'min' 			=> 'El campo :attribute no puede tener menos de :min carácteres.',
			'same'			=> 'La confirmación de la contraseña y la contraseña no coinciden.',
		);

		$validator = User::validate($data, $rules, $messages);

		if(!$validator->fails())
		{
			$user = new User;
			$user->name = Input::get('name');
			$user->phone = Input::get('phone');
			$user->email = mb_strtolower(trim(Input::get('email')));
			$user->password = Hash::make(Input::get('password'));
			$user->type = 3;
			$user->code = self::generateRandomString(20);
			$user->facebookId = 0;
			$user->state = 0;
			if($user->save())
			{
				self::setPrivileges($user->id, ['view' => 0, 'edit' => 0, 'delete' => 0]);

				$data = [
					'name' => Input::get('name'),
					'code' => $user->code,
				];
				Mail::queue('emails.activation', ['data' => $data], function($msg)
				{
					$msg->from('registro@testclickdelivery.com', 'Test Click Delivery');
					$msg->to(mb_strtolower(trim(Input::get('email'))), Input::get('name'))->subject('Activación de registro');
				});
				$message = ['message' => 'Registro exitoso, se envío un correo a '.mb_strtolower(trim(Input::get('email'))).' para activar su cuenta', 'type' => 'alert-success', 'state' => true];
			}
			else
				$message = ['message' => 'Ha ocurrdo un error al registrar sus datos, por favor intente nuevamente', 'type' => 'alert-danger', 'state' => false];
		}else{
			$messagesValidation = $validator->messages();
			$err = '';
			foreach ($messagesValidation->all() as $msj){
				$err .= $msj.'<br>';
			}
			$message = ['message' => $err, 'type' => 'alert-danger', 'state' => false];
		}

		if($message['state'])
			return Redirect::back()->withErrors($message);
		else
			return Redirect::back()->withErrors($message)->withInput(Input::except('password'));
	}

}
