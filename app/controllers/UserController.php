<?php

class UserController extends BaseController {

	public function index()
	{
		$privileges = self::getMyPrivileges();
		$users = [];
		if($privileges['view'])
		{
			$users = User::where('id', '<>', Auth::user()->id)->orderBy('name');
			if(Auth::user()->type != 1)
				$users = $users->whereType(3);
			$users = $users->get();
		}

		return View::make('user_list')->with('users', $users)->with('privileges', $privileges);
	}

	public function create()
	{
		return View::make('user_form');
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
			$user->type = 2;
			$user->code = self::generateRandomString(20);
			$user->facebookId = 0;
			$user->state = 0;
			if($user->save())
			{
				$privileges = [
					'view' => (Input::has('view') ? 1 : 0), 
					'edit' => (Input::has('edit') ? 1 : 0), 
					'delete' => (Input::has('delete') ? 1 : 0)
				];
				self::setPrivileges($user->id, $privileges);

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
				$message = ['message' => 'Ha ocurrdo un error al registrar sus datod, por favor intente nuevamente', 'type' => 'alert-danger', 'state' => false];
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

	public function edit($id)
	{
		$privileges = self::getMyPrivileges();
		if(!$privileges['view'] || !$privileges['edit'])
			return Redirect::to('users')->withErrors(['message' => 'No tiene permisos para realizar esta acción', 'type' => 'alert-danger']);

		$privileges = self::getPrivileges($id);
		$user = User::find($id);
		try
		{
			if($user->type == 1)
				App::abort(404);
		}
		catch(\Exception $ex)
		{
			App::abort(404);
		}

		return View::make('user_form_edit')->with('user', $user)->with('privileges', $privileges);
	}

	public function update($id)
	{
		$privileges = self::getMyPrivileges();
		if(!$privileges['edit'])
			return Redirect::to('users');

		$data = array(
			'nombre'	=> Input::get('name'),
			'teléfono'	=> Input::get('phone'),
		);

		$rules = array(
			'nombre'	=> 'required|max:60',
			'teléfono'	=> 'max:20',
		);

		if(Input::get('password') != '')
		{
			$data['contraseña'] 				= Input::get('password');
			$data['confirmación_contraseña'] 	= Input::get('password_r');

			$rules['contraseña'] 				= 'required|min:6';
			$rules['confirmación_contraseña'] 	= 'required|same:contraseña';
		}

		$messages = array(
			'required'		=> 'El campo :attribute es requerido.',
			'unique'		=> 'Ya existe un usuario registrado con el :attribute ('.mb_strtolower(trim(Input::get('email'))).').',
			'confirmed'		=> 'La confirmación de la :attribute no coinciden.',
			'max' 			=> 'El campo :attribute no puede tener más de :max carácteres.',
			'min' 			=> 'El campo :attribute no puede tener menos de :min carácteres.',
			'same'			=> 'La confirmación de la contraseña y la contraseña no coinciden.',
		);

		$validator = User::validate($data, $rules, $messages);

		if(!$validator->fails())
		{
			$user = User::find($id);
			$user->name = Input::get('name');
			$user->phone = Input::get('phone');
			if(Input::get('password') != '')
				$user->password = Hash::make(Input::get('password'));
			if($user->save())
			{
				$privileges = [
					'view' => (Input::has('view') ? 1 : 0), 
					'edit' => (Input::has('edit') ? 1 : 0), 
					'delete' => (Input::has('delete') ? 1 : 0)
				];
				self::setPrivileges($id, $privileges);

				$message = ['message' => 'Lo datos del usuario se actualizarón correctamente', 'type' => 'alert-success', 'state' => true];
			}
			else
				$message = ['message' => 'Ha ocurrdo un error al actualizar los datos del usuario, por favor intente nuevamente', 'type' => 'alert-danger', 'state' => false];
		}else{
			$messagesValidation = $validator->messages();
			$err = '';
			foreach ($messagesValidation->all() as $msj){
				$err .= $msj.'<br>';
			}
			$message = ['message' => $err, 'type' => 'alert-danger', 'state' => false];
		}

		return Redirect::back()->withErrors($message)->withInput(Input::except('password'));
	}

	public function destroy($id)
	{
		$privileges = self::getMyPrivileges();
		if($privileges['delete'])
		{
			$userDeleted = User::whereId($id)->where('type', '<>', 1)->delete();
			if($userDeleted)
			{
				self::deletePrivileges($id);
				$message = ['message' => 'ok', 'state' => true];
			}
			else
				$message = ['message' => 'No se puedo eliminar el usuario', 'state' => false];
		}
		else
			$message = ['message' => 'No tiene permisos para realizar esta acción', 'state' => false];

		return Response::json($message);
	}

	public function activation($code)
	{
		$user = User::whereCode($code);
		if($user->get()->count() > 0)
		{
			if($user->get()->first()->state == 0)
			{
				$user->update(['state' => 1]);
				$message = ['message' => 'Su cuenta ha sido activada, ya puede iniciar sesión', 'type' => 'alert-success'];
			}else{
				$message = ['message' => 'Su cuenta ya había sido activada, por favor inicie sesión', 'type' => 'alert-danger'];
			}
			return Redirect::to('login')->withErrors($message);
		}else{
			$message = ['message' => 'No se encontro la cuenta asociada al código de activación, registrese para obtener una cuenta', 'type' => 'alert-danger'];
			return Redirect::to('register')->withErrors($message);
		}
	}

}
