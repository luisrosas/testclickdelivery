<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public static function generateRandomString($longitud = 10) {
		$key = '';
		$pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
		$max = strlen($pattern)-1;
		for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
		return $key;
	}

	public static function setPrivileges($user_id, $privileges)
	{
		$userPrivilege = UserPrivilege::find($user_id);
		if(!$userPrivilege)
		{
			$userPrivilege = new UserPrivilege;
			$userPrivilege->user_id = $user_id;
		}

		$userPrivilege->view = $privileges['view'];
		$userPrivilege->edit = $privileges['edit'];
		$userPrivilege->delete = $privileges['delete'];
		$userPrivilege->save();
	}

	public static function getPrivileges($user_id)
	{
		$userPrivilege = UserPrivilege::select('view', 'edit', 'delete')->whereUserId($user_id)->get();
		if($userPrivilege->count() > 0)
			$userPrivilege = $userPrivilege->first()->toArray();
		else
			$userPrivilege = ['view' => 0, 'edit' => 0, 'delete' => 0];

		return $userPrivilege;
	}

	public static function getMyPrivileges()
	{
		if(Auth::user()->type == 1)
			$myPrivilege = ['view' => 1, 'edit' => 1, 'delete' => 1];
		else
			$myPrivilege = self::getPrivileges(Auth::user()->id);

		return $myPrivilege;
	}

	public static function deletePrivileges($user_id)
	{
		return UserPrivilege::whereUserId($user_id)->delete();
	}

}
