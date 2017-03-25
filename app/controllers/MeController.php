<?php

class MeController extends BaseController {

	public function edit()
	{
		$me = User::find(Auth::user()->id);
		return View::make('me_form')->with('me', $me);
	}

	public function update()
	{
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
			$user = User::find(Auth::user()->id);
			$user->name = Input::get('name');
			$user->phone = Input::get('phone');
			if(Input::get('password') != '')
				$user->password = Hash::make(Input::get('password'));
			if($user->save())
				$message = ['message' => 'Sus datos de actualizarón correctamente', 'type' => 'alert-success', 'state' => true];
			else
				$message = ['message' => 'Ha ocurrdo un error al actualizar sus datos, por favor intente nuevamente', 'type' => 'alert-danger', 'state' => false];
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

}
