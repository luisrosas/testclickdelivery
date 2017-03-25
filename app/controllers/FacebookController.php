<?php

class FacebookController extends \BaseController {

	private $fb;

	public function __construct(FacebookHelper $fb)
	{
		$this->fb = $fb;
	}

	public function login()
	{
		return Redirect::to($this->fb->getUrl(url('login/fb/callback')));
	}

	public function register()
	{
		return Redirect::to($this->fb->getUrl(url('register/fb/callback')));
	}

	public function callbackLogin()
	{
		$userFB = $this->fb->getDataUser();
		if(!$userFB)
		{
			return Redirect::to('/')->with('message', 'Error, al intentar iniciar sesión con Facebook');
		}
		
		$user = User::where('facebookId', $userFB['id'])->get();

		if($user->count() > 0)
		{
			if($user->first()->state == 1)
			{
				Auth::login($user->first(), false);
				return Redirect::to('users');
			}else{
				$message = ['message' => 'Su cuenta aún no ha sido activada, debe activarla para poder acceder', 'type' => 'alert-danger'];
				return Redirect::back()->withErrors($message);
			}
		}else{
			$message = ['message' => 'No se encontraron datos coincidentes, registrese para crear una cuenta', 'type' => 'alert-danger'];
				return Redirect::to('register')->withErrors($message);
		}
	}

	public function callbackRegister()
	{
		$userFB = $this->fb->getDataUser();
		if(!$userFB)
		{
			return Redirect::to('/')->with('message', 'Error, al intentar registrarse con Facebook');
		}
		
		$data = array(
			'correo'	=> mb_strtolower($userFB['email'])
		);
		$rules = array(
			'correo'	=> 'required|email|unique:users,email|max:100'
		);
		$messages = array(
			'required'	=> 'El campo :attribute es requerido.',
			'unique'	=> 'Ya existe un usuario registrado con el :attribute ('.mb_strtolower($userFB['email']).').',
			'email'		=> 'El formato del :attribute no es válido.',
			'max' 		=> 'El campo :attribute no puede tener más de :max carácteres.',
		);

		$validator = User::validate($data, $rules, $messages);

		if(!$validator->fails())
		{
			$user = new User;
			$user->name = $userFB['name'];
			$user->phone = '';
			$user->email = $userFB['email'];
			$user->password = Hash::make(self::generateRandomString(6));
			$user->type = 3;
			$user->code = self::generateRandomString(20);
			$user->facebookId = $userFB['id'];
			$user->state = 0;
			if($user->save())
			{
				self::setPrivileges($user->id, ['view' => 0, 'edit' => 0, 'delete' => 0]);
				
				$data = [
					'name' => $userFB['name'],
					'code' => $user->code,
				];
				Mail::queue('emails.activation', ['data' => $data], function($msg) use ($userFB)
				{
					$msg->from('registro@testclickdelivery.com', 'Test Click Delivery');
					$msg->to(mb_strtolower($userFB['email']), $userFB['name'])->subject('Activación de registro');
				});
				$message = ['message' => 'Registro exitoso, se envío un correo a '.mb_strtolower($userFB['email']).' para activar su cuenta', 'type' => 'alert-success'];
			}
			else
				$message = ['message' => 'Ha ocurrdo un error al registrar sus datos, por favor intente nuevamente', 'type' => 'alert-danger'];
		}else{
			$messagesValidation = $validator->messages();
			$err = '';
			foreach ($messagesValidation->all() as $msj){
				$err .= $msj.'<br>';
			}
			$message = ['message' => $err, 'type' => 'alert-danger'];
		}
		

		return Redirect::back()->withErrors($message);
	}

}
