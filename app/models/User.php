<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;

class User extends Eloquent implements UserInterface {

	use UserTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');


	public function privileges()
	{
		return $this->hasOne('UserPrivilege')->get()->first();
	}

	// Validar formulario
	public static function validate($data, $rules, $message)
	{
		return Validator::make($data, $rules, $message);
	}

}
